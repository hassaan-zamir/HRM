<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\Employees;
use App\Attendance;
use Carbon\Carbon;
use App\Roster;
use App\RosterShifts;
use App\Http\Controllers\HelperController;
use TADPHP\TADFactory;
use TADPHP\TAD;

class AttendanceController extends Controller
{


  public function index()
  {
    $departments = Department::all();
    $employees = Employees::all();
    return view('attendance.index')->with([
      'departments' => $departments,
      'employees' => $employees,
    ]);
  }

  public function view(Request $request){


    //Finalizing Employee Ids Array
    $employee_ids = $request->employeeSelection;
    //if all employees
    if($employee_ids[0] == 0){
      $department_ids = $request->departmentSelection;
      //if all departments
      if($department_ids[0] == 0){
        $employee_ids = Employees::select('id')->get()->toArray();
        $i = 0;
        foreach($employee_ids as $employee_id){
          $employee_ids[$i] = $employee_id['id'];
          $i++;
        }
      }else{
        $employee_ids = array();
        foreach($department_ids as $department_id){
          $tmp = Employees::select('id')->where('department','=',$department_id)->get()->toArray();
          foreach($tmp as $t){
            array_push($employee_ids,$t['id']);
          }
        }
      }
    }
    //employee ids finalized .

    //making return array structure
    $dataArr = array();

    //looping through each employees
    foreach($employee_ids as $e_code){
      $appendArr = array();
      $appendArr['e_code'] = $e_code;

      $employee = Employees::findOrFail($e_code);
      $e_name = $appendArr['name'] = $employee->full_name;
      $department = $appendArr['department'] = (Department::findOrFail($employee->department))->name;
      $date = Carbon::parse($request->date);


      //finding right roster for the right date for the right employee
      $fetchRoster = null;
      $fetchRosters= Roster::where('start','<=',$date)->where('end','>=',$date)->orderBy('id','desc')->get();
      foreach($fetchRosters as $fetchRosterloop){
        if($fetchRosterloop->dep_id == '0' && $fetchRosterloop->employee_id == '0'){
          $fetchRoster = $fetchRosterloop;
          break;
        }else if($fetchRosterloop->dep_id == '0'){
          if( in_array($e_code,explode(',',$fetchRosterloop->employee_id) ) ){
            $fetchRoster = $fetchRosterloop;
            break;
          }
        }else if($fetchRosterloop->employee_id == '0'){

          $dep_tmp = explode(',',$fetchRosterloop->dep_id);

          $find = Employees::where('id','=',$e_code)->whereIn('department',$dep_tmp)->get();

          if(count($find) > 0 ){

            $fetchRoster = $fetchRosterloop;
            break;
          }
        }else{
          if(in_array($e_code,explode(',',$fetchRosterloop->employee_id))){
            $fetchRoster = $fetchRosterloop;
            break;
          }
        }
      }

      /* roster finding end*/

      $nextDay = Carbon::parse($request->date)->addDays(1)->toDateString();
      $fetchAttendance = Attendance::where('employee_id','=',$e_code)->where('time','>=',Carbon::parse($request->date.' 0800'))->where('time','<',Carbon::parse($nextDay.' 0800'))->orderBy('time','asc')->get();

      if($fetchRoster == null ){
        //if no roster was found
        $appendArr['in_time'] = $appendArr['out_time'] = $appendArr['worked_duration'] = $appendArr['calc_ot'] = $appendArr['man_ot'] = null;
        $appendArr['in_time_id'] = $appendArr['out_time_id'] = 0;
        $appendArr['man_ot_hr'] = $appendArr['man_ot_min'] = $appendArr['man_ot_sec'] = '0';
        $appendArr['shift_details'] = null;

      }else if(count($fetchAttendance) <= 0){
        //if no attendance was found
        $appendArr['in_time'] = $appendArr['out_time'] = $appendArr['worked_duration'] = $appendArr['calc_ot'] = $appendArr['man_ot'] = null;
        $appendArr['in_time_id'] = $appendArr['out_time_id'] = 0;
        $appendArr['man_ot_hr'] = $appendArr['man_ot_min'] = $appendArr['man_ot_sec'] = '0';
        $appendArr['shift_details'] = null;
      }else{
        //if roster and attendace both were found
        $fetchRoster = $fetchRoster->toArray();
        $shift = (RosterShifts::findOrFail($fetchRoster['roster_shift_id'])->get())[0];
        $appendArr['shift_details'] = $shift->toArray();
        $fetchAttendance = $fetchAttendance->toArray();
        $appendArr['in_time'] = Carbon::parse($fetchAttendance[0]['time']);

        $appendArr['in_time_id'] = $fetchAttendance[0]['id'];
        if(count($fetchAttendance) == 1){
          //if only one attendance
          $appendArr['worked_duration'] = null;
          $appendArr['out_time'] = $appendArr['calc_ot'] = $appendArr['man_ot'] = '';
          $appendArr['man_ot_hr'] = $appendArr['man_ot_min'] = $appendArr['man_ot_sec'] = '0';
          $appendArr['out_time_id'] = 0;
        }else{
          //in/out/ot info
          $appendArr['out_time'] = Carbon::parse($fetchAttendance[count($fetchAttendance)-1]['time']);
          $appendArr['out_time_id'] = $fetchAttendance[count($fetchAttendance)-1]['id'];
          $shiftEndTime = $appendArr['in_time']->toDateString().' '.$shift->start_time;
          $shiftEndTime = Carbon::parse($shiftEndTime)->addHours($shift->shift_duration)->addMinutes(60*($shift->shift_duration - floor($shift->shift_duration)));
          if($appendArr['out_time'] > $shiftEndTime){

            $overtime = $shiftEndTime->diffInMinutes($appendArr['out_time']);
            if( $overtime >= ($shift->overtime_start_time*60) ){
              $appendArr['calc_ot'] = floor($overtime/60).'hr '.($overtime%60).' mins';
            }else{
              $appendArr['calc_ot'] = '0';
            }

          }else{
            $appendArr['calc_ot'] = '0';
          }

          //work duration from in/out time
          $duration = $appendArr['in_time']->diffInSeconds($appendArr['out_time']);
          $appendArr['worked_duration'] = $duration;

          // manual overtime info
          $manual_overtime = $fetchAttendance[0]['manual_overtime'];
          if($manual_overtime == 0){
            $appendArr['man_ot'] = $appendArr['man_ot_hr'] = $appendArr['man_ot_min'] = $appendArr['man_ot_sec'] = '0';
          }else{
            $appendArr['man_ot_hr'] = $manual_overtime_hr = floor(($manual_overtime/60)/60);
            $appendArr['man_ot_min'] = $manual_overtime_mins = floor(($manual_overtime/60)%60);
            $appendArr['man_ot_sec'] = $manual_overtime_secs = floor(($manual_overtime%60)%60);
            $appendArr['man_ot'] = $manual_overtime_hr.':'.$manual_overtime_mins.':'.$manual_overtime_secs;
          }

        }

      }
      array_push($dataArr,$appendArr);
    }

    return view('attendance.view')->with([
      'data' => $dataArr,
      'date' => $request->date,
    ]);






  }


  public function saveChanges(Request $request){

    $returnArr = [
      'status' => 'Faliure',
      'message' => 'Changes could not be saved due to unkwon reasons. try again later',
    ];
    if(!isset($request->date) || empty($request->date)){
      $returnArr['status'] = 'Faliure';
      $returnArr['message'] = 'Dataset to be updated was corrupted or invalid';
    }else if(!isset($request->changes) || empty($request->changes)){
      $returnArr['status'] = 'Faliure';
      $returnArr['message'] = 'No Changes found to be saved';
    }else{//all data is validated
      //for each change started
      foreach($request->changes as $change){


        if(isset($change['man_ot']) && !empty($change['man_ot'])){
          $manual_overtime = $change['man_ot'];
        }else{
          $manual_overtime = 0;
        }

        if(isset($change['in_time']) && $change['in_time_id']!=0 ){
          $inTime = Carbon::parse($request->date.' '.$change['in_time']);
          $updateInAttendance = Attendance::findOrFail($change['in_time_id'])->update(['time' => $inTime]);
        }else if(isset($change['in_time'])){
          $inTime = Carbon::parse($request->date.' '.$change['in_time']);
          $insertAttendance = Attendance::create(['employee_id' => $change['e_code'], 'manual_overtime' => 0, 'time' => $inTime]);
        }

        if(isset($change['worked_duration'])){

          if(isset($change['in_time'])){
            $inTime = Carbon::parse($request->date.' '.$change['in_time']);
          }else{
            $inTime = Carbon::parse((Attendance::where('time','>=',Carbon::parse($request->date.' 0800'))->where('employee_id','=',$change['e_code'])->orderBy('time','asc')->get())[0]->time);

          }

          $outTime = $inTime->addSeconds(HelperController::clockToSeconds($change['worked_duration']));

          if($change['out_time_id']!=0){
            $updateOutAttendance = Attendance::findOrFail($change['out_time_id'])->update(['time' => $outTime]);
          }else{
            $insertOutAttendance = Attendance::create(['employee_id' => $change['e_code'], 'manual_overtime' => 0, 'time'=> $outTime ]);
          }

        }


      }
      //foreach change ended
    }//all validated changes applied

    $returnArr['status'] = 'Success';
    $returnArr['message'] = 'Changes Saved Successfully';
    return json_encode($returnArr);

  }

  private function getLogs($ip,$pin){
    $options = [
      'ip' => $ip,
      // 'internal_id' => 100,
      // 'com_key' => 123,
      // 'description' => 'TAD1',
      // 'soap_port' => 8080,
      // 'udp_port' => 20000,
      // 'encoding' => 'utf-8',
    ];

    $tad_factory = new TADFactory($options);
    $tad = $tad_factory->get_instance();


    $logs = $tad->get_att_log(['pin' => $pin])->to_array();
    return $logs;
  }
  public function import(Request $request){
    $file = $request->file('importFile');
    $contents = json_decode(file_get_contents($file));
    $contents = $contents->Row;
    $ip = $request->ip;
    $from = Carbon::parse($request->from);
    $till = Carbon::parse($request->till);

    $employees = Employees::all();
    foreach($employees as $employee){
      $pin = ($employee->machine_id);
      //$get_logs = $this->getLogs($ip,$pin);
      //$get_logs = $get_logs['Row'];
      foreach($contents as $log){

        if($log->PIN == $pin){
          $dateTime = Carbon::parse($log->DateTime);
          if($dateTime >= $from && $dateTime <= $till){
            $check = Attendance::where('employee_id','=',$employee->id)->where('time','=',$dateTime)->get();
            if(count($check) == 0){
              $reqArr = [
                'employee_id' => $employee->id,
                'manual_overtime' => 0,
                'time' => $dateTime
              ];
              Attendance::create($reqArr);
            }
          }
        }
      }
    }

    return view('attendance.import')->with(['status' => 'Attendance Imported Successfully.']);
  }

  public function importFront(){

    return view('attendance.import')->with([
    ]);
  }

}
