<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Attendance;
use App\Employees;
use App\Roster;
use App\RosterShifts;
use App\Department;
use App\PublicHolidays;
use App\Leaves;
use App\Http\Controllers\HelperController;

class ReportsController extends Controller
{


  /* Helper Funcstions start*/


  public function fetchRoster($date,$e_code){
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
    return $fetchRoster;
  }

  /*Helper Functions End */

  public function monthlyTimeRegisterFront(){
    return view('reports.monthlyTimeRegisterFront')->with([

    ]);
  }

  public function monthlyEmployeeFront(){
    $employees = Employees::all();
    return view('reports.monthlyEmployeeFront')->with([
      'employees' => $employees,
    ]);
  }


  public function monthlyTimeRegister(Request $request){

    $request->date = Carbon::parse($request->date);
    $month = $request->date->month;
    $year = $request->date->year;

    $data = array();
    $totalDays = cal_days_in_month(CAL_GREGORIAN,$month,$year);
    $employees = Employees::all();
    foreach($employees as $employee){
      $reqSend = new Request();
      $reqSend->month = $month; $reqSend->year = $year; $reqSend->eid = $employee->id;
      $employeeReport = $this->monthlyEmployeeReport($reqSend,0);
      
      $employeeReport['summaryHeadings'] = ['TD','WD','LD','ED','TH','WH','AB','HW','LP','LE','OT','SD','CL','AL'];
      $employeeReport['summaryResults'] = [
        $employeeReport['workSummary']['work_days'],
        $employeeReport['workSummary']['worked_days'],
        $employeeReport['leSummary']['late_days'],
        $employeeReport['leSummary']['early_days'] ,
        $employeeReport['workSummary']['working_hours'],
        \App\Http\Controllers\HelperController::secondsToClock($employeeReport['workSummary']['worked_hours']),
        $employeeReport['extraSummary']['absent'],
        $employeeReport['extraSummary']['holiday'],
        floor($employeeReport['leSummary']['late_days']/3),
        \App\Http\Controllers\HelperController::secondsToClock($employeeReport['leSummary']['early_hours']+$employeeReport['leSummary']['late_hours'],':',1),
        \App\Http\Controllers\HelperController::secondsToClock($employeeReport['extraSummary']['overtime'],':',1),
        $employeeReport['workSummary']['short_duty_hours'],
        $employeeReport['leavesSummary']['casual_leaves'],
        $employeeReport['leavesSummary']['annual_leaves'],
      ];
      array_push($data,$employeeReport);
    }
    // dd($employeeReport);
    return view('reports.monthlyTimeRegister')->with([
      'totalDays' => $totalDays,
      'employeeReports' => $data,
      'month' => $month,
      'year' => $year,
    ]);
  }



  public function monthlyEmployeeReport(Request $request,$view = 1){

    //handling different types of date inputs
    if(isset($request->date)){
      $request->date = Carbon::parse($request->date);
      $month = $request->date->month;
      $year = $request->date->year;
    }else{
      $month = $request->month;
      $year = $request->year;
    }

    //getting employee id
    $e_id = $request->eid;

    //find employee
    $employee = Employees::findOrFail($e_id);

    $employee = $employee->toArray();

    //get department name for view
    $employee['department'] = (Department::findOrFail($employee['department'])->toArray())['name'];


    //creating return result arrays dummy
    $workSummary = array(
      'work_days' => 0,
      'worked_days' => 0,
      'worked_hours' => 0,
      'working_hours' => 0,
      'short_duty_hours' => 0,
    );
    $leSummary = array(
      'late_days' => 0,
      'early_days' => 0,
      'late_hours' => 0,
      'early_hours' => 0,
    );
    $extraSummary = array(
      'absent' => 0,
      'holiday' => 0,
      'overtime' => 0,
    );

    $leavesSummary = array(
      'casual_leaves' => 0,
      'annual_leaves' => 0,
    );

    //main data
    $rows = array();

    //starting loop of whole month
    $date = Carbon::parse('1-'.$month.'-'.$year);

    $loopIndex = 0;

    //loop start
    while($date->month == $month){

      //If date is not before employee join date
      if($date >= Carbon::parse($employee['join_date']) ){

        $publicHoliday = PublicHolidays::whereDate('date','=',$date)->get(); //getting public holidays of this date
        if($date->dayOfWeek != 0){
          if($publicHoliday->count() == 0){
            //if it is not sunday and not a public holiday then increase work days
            $workSummary['work_days']++;
          }
        }

        //single row to be appended
        $row = array();

        //date for view
        $rowDate = (explode(' ',$date->toDateTimeString()))[0];
        $row['date'] = $date->day.'-'.$date->month.'-'.$date->year.' ('.HelperController::dayOfWeek($date->dayOfWeek).')';

        //fetching attendance of emp[e_id][date]

        $dateStr = $date->toDateString();
        $nextDay = Carbon::parse($dateStr)->addDays(1)->toDateString();

        $fetchAttendance = Attendance::where('employee_id','=',$e_id)->where('time','>=',Carbon::parse($dateStr.' 0731'))->where('time','<',Carbon::parse($nextDay.' 0730'))->orderBy('time','asc')->get();

        //fetching roster
        $fetchRoster = $this->fetchRoster($date,$e_id);

        //if roster is not null for today then getting shift timings and setting lunch duration , also adding to working hours
        if($fetchRoster!= null){
          //getting shift details
          $shiftDetails = RosterShifts::findOrFail($fetchRoster->roster_shift_id);

          if($date->dayOfWeek == 0){
            $shiftStarting = Carbon::parse($rowDate.' '.$shiftDetails->sunday_start_time);
            $shiftEnding = Carbon::parse($rowDate.' '.$shiftDetails->sunday_start_time)->addHours($shiftDetails->sunday_shift_duration)->addMinutes(60*($shiftDetails->sunday_shift_duration - floor($shiftDetails->sunday_shift_duration)));

          }else{
            $shiftStarting = Carbon::parse($rowDate.' '.$shiftDetails->start_time);
            $addMinutes = floor(60*($shiftDetails->shift_duration - floor($shiftDetails->shift_duration)));
            $shiftEnding = Carbon::parse($rowDate.' '.$shiftDetails->start_time)->addHours( floor($shiftDetails->shift_duration) )->addMinutes($addMinutes);

          }

          if($date->dayOfWeek != 0){
            $lunch_duration = $shiftDetails->lunch_duration;
            if($publicHoliday->count() == 0){
              $shiftDuration = ($shiftEnding->diffInSeconds($shiftStarting))/3600;
              $workSummary['working_hours'] += ($shiftDuration-$lunch_duration);
            }
          }else{
            $lunch_duration = $shiftDetails->sunday_lunch_duration;
          }

        }else{
          //if no roster found then lunch duration to add is 0
          $lunch_duration = 0;
        }

        //if attendance of in and out both is marked
        if(count($fetchAttendance) >= 2){

          $fetchAttendance = $fetchAttendance->toArray();
          $inAttendance = $fetchAttendance[0];
          $outAttendance = $fetchAttendance[count($fetchAttendance)-1];

          $row['in_time'] = explode(':',explode(' ',Carbon::parse($inAttendance['time'])->toDateTimeString())[1]);
          $row['in_time'] = $row['in_time'][0].':'.$row['in_time'][1];

          $row['out_time'] = explode(':',explode(' ', Carbon::parse($outAttendance['time'])->toDateTimeString() )[1]);

          $row['out_time'] = $row['out_time'][0].':'.$row['out_time'][1];

          $outTime = Carbon::parse($outAttendance['time']);
          $inTime = Carbon::parse($inAttendance['time']);

          $lunchStartTime = Carbon::parse($rowDate.' 14:00:00');
          $lunchEndTime = Carbon::parse($rowDate.' 14:00:00')->addHours($lunch_duration);

          if($outTime > $inTime){
            $row['worked_hours'] = $outTime->diffInSeconds($inTime);
            if($inTime > $lunchStartTime && $inTime < $lunchEndTime){
              $row['worked_hours'] -= ($lunchEndTime->diffInSeconds($inTime));
            }else if($inTime < $lunchStartTime){
              $row['worked_hours'] -= ($lunch_duration*3600);
            }
            $workSummary['worked_hours'] += $row['worked_hours'];
          }else {
            $row['worked_hours'] = 0;
          }


          if($fetchRoster != null){

            if($date->dayOfWeek == 0){
              $row['holiday'] = 'Sunday';

              $extraSummary['holiday']++;
            }
            $workSummary['worked_days']++;

            $row['status'] = 'Present';




            if($shiftStarting > $inTime){
              $row['worked_hours'] = $outTime->diffInSeconds($shiftStarting);
              $workSummary['worked_hours'] += $row['worked_hours'];
            }


            $row['shift'] = $shiftDetails->name.' '.(explode(':',(explode(' ',$shiftStarting->toDateTimeString())[1])))[0].':'.(explode(':',(explode(' ',$shiftStarting->toDateTimeString())[1])))[1].' - '.(explode(':',(explode(' ',$shiftEnding->toDateTimeString())[1])))[0].':'.(explode(':',(explode(' ',$shiftEnding->toDateTimeString())[1])))[1];



            if($outTime >= $shiftEnding){
              $overtime = $outTime->diffInSeconds($shiftEnding);
              if($date->dayOfWeek == 0){
                $minimumOvertime = ($shiftDetails->sunday_overtime_start_time)*60*60;
              }else{
                $minimumOvertime = ($shiftDetails->overtime_start_time)*60*60;
              }


              if($overtime > $minimumOvertime){
                $row['ot'] = $overtime;
                $extraSummary['overtime'] += $overtime;
              }else{

                $row['ot'] = 0;
              }
            }else{
              $row['ot'] = 0;
            }

            if($inTime<=$shiftStarting){
              $row['late_hrs'] = 0;
            }else{
              $lateHours = $shiftStarting->diffInSeconds($inTime);
              if($date->dayOfWeek == 0){
                $minimumLate = ($shiftDetails->sunday_late_time)*60*60;
              }else{
                $minimumLate = ($shiftDetails->late_time)*60*60;
              }

              if($lateHours > $minimumLate){
                $leSummary['late_days']++;
                $row['late_hrs'] = $lateHours;
                $leSummary['late_hours'] += ($lateHours);
                $row['status'] = '<span style="color:#2980b9;">Late</span>';
              }else{
                $row['late_hrs'] = 0;
              }
            }

            if($outTime>=$shiftEnding){
              $row['early_hrs'] = 0;
            }else{
              $earlyHrs = $shiftEnding->diffInSeconds($outTime);
              if($date->dayOfWeek == 0){
                $minimumEarly = ($shiftDetails->sunday_early_go_time)*60*60;
              }else{
                $minimumEarly = ($shiftDetails->early_go_time)*60*60;
              }

              if($earlyHrs > $minimumEarly){
                $leSummary['early_days']++;
                $row['early_hrs'] = $earlyHrs;
                $leSummary['early_hours'] += $earlyHrs;

                if (strpos($row['status'], 'Late') !== false) {
                  $row['status'] = '<span style="color:#2980b9;">Late/Early</span>';
                }else{
                  $row['status'] = '<span style="color:#2980b9;">Early</span>';
                }

              }else{
                $row['early_hrs'] = 0;
              }
            }

          }else{

            $row['status'] = 'No Roster';
            $row['worked_hours'] = $row['in_time'] = $row['out_time'] = $row['shift'] = $row['ot'] = $row['late_hrs'] = $row['early_hrs'] = '';
          }

        }else{

          if($date->dayOfWeek != 0){
            $extraSummary['absent']++;
            $row['status'] = '<span style="color:#c0392b;">Absent</span>';
          }else{
            $row['status'] = '<span style="color:#27ae60;">(Sunday)</span>';
          }

          if($date->dayOfWeek == 1 && $loopIndex >= 2){
            if(strpos($rows[$loopIndex-2]['status'], 'Absent') !== false && $rows[$loopIndex-1]['in_time'] == '' && $rows[$loopIndex-1]['out_time'] == '' ){
              $extraSummary['absent']++;
              $rows[$loopIndex-1]['status'] = '<span style="color:#27ae60;">(Sunday)</span><span style="color:#c0392b;"> Absent</span>';
            }
          }


          $row['worked_hours'] = $row['in_time'] = $row['out_time'] = $row['shift'] = $row['ot'] = $row['late_hrs'] = $row['early_hrs'] = '';

        }
        //if condition of check attendance count is ended

        //checking holiday and showing status accordingly
        if(count($publicHoliday)>0){
          $publicHoliday = ($publicHoliday[0])->toArray();
          if(strpos($row['status'],'Absent') !== false ) {
            $extraSummary['absent']--;
            $append = '';
          }else if(strpos($row['status'],'Sunday') == false){
            $extraSummary['holiday']++;
            //dd($date);

            $append = $row['status'];
          }
          $row['status'] = '<span style="color:#27ae60">('.$publicHoliday['title'].')</span>'.$append;
        }else{

          //checking leaves and showing status accordingly
          $leave = Leaves::whereDate('start_date','<=',$date)->whereDate('end_date','>=',$date)->where('emp_id','=',$e_id)->get();
          foreach($leave as $leaveRow){
            if($leave->type='Casual'){
              $leavesSummary['casual_leaves']++;
            }else{
              $leavesSummary['annual_leaves']++;
            }
          }
          if(count($leave)>0){
            $leave = ($leave[0])->toArray();
            if(strpos($row['status'],'Absent') !== false){
              $extraSummary['absent']--;
              $append = '';
            }else{
              $extraSummary['holiday']++;

              $append = $row['status'];
            }
            $row['status'] = '<span style="color:#27ae60">(Leave: '.$leave['subject'].')</span>'.$append;
          }
        }
        //holiday checking end

        array_push($rows,$row);
      }else{
        //before join date employee showed as absent
        $row = array();
        $row['date'] = $date->day.'-'.$date->month.'-'.$date->year.' ('.HelperController::dayOfWeek($date->dayOfWeek).')';
        $row['worked_hours'] = $row['in_time'] = $row['out_time'] = $row['shift'] = $row['ot'] = $row['late_hrs'] = $row['early_hrs'] = '';
        $row['status'] = '<span style="color:#c0392b;"> Absent</span>';
        array_push($rows,$row);
        $extraSummary['absent']++;
      }

      $date->addDays(1);
      $loopIndex++;
    }
    //loop end

    if($workSummary['worked_hours'] > $workSummary['working_hours']){
      //dd($workSummary['worked_hours'],)
      $workSummary['short_duty_hours'] = 0;
    }else{
      $workSummary['short_duty_hours'] = $workSummary['working_hours']-$workSummary['worked_hours'];
    }

    $withData = [
      'rows' => $rows,
      'employee' => $employee,
      'workSummary' => $workSummary,
      'leSummary' => $leSummary,
      'extraSummary' => $extraSummary,
      'leavesSummary' => $leavesSummary,
    ];

    if($view == 0){
      return $withData;
    }

    return view('reports.monthlyEmployee')->with($withData);
  }

  public function multipleInOutFront(){

    return view('reports.multipleInOutFront')->with([

    ]);
  }


  public function multipleInOut(Request $request){


    $dataArr = array();

    $date = Carbon::parse($request->date);
    $workStart = $date->copy()->addHours(8);
    $workEnd = $workStart->copy()->addHours(23)->addMinutes(59);

    $dataFetch = Attendance::select(['attendance.id as id','attendance.time','employees.full_name','attendance.employee_id'])->join('employees','employees.id','=','attendance.employee_id')->where('attendance.time','>=',$workStart)->where('attendance.time','<=',$workEnd)->get();

    foreach($dataFetch as $fetchData){//foreach attendance entry



      $wasEmployeeAdded = 0;
      foreach($dataArr as $prevData){//previous data loop

        if($prevData['employee_id'] == $fetchData->employee_id){//if employee already added


          $index =0 ;

          foreach($prevData['entries'] as $entry ){
            if($fetchData->time == $entry){
              $index = -1;
              break;
            }else if($fetchData->time > $entry ){
              break;
            }
            $index++;
          }

          $insert = array( $fetchData->time );
          array_splice( $dataArr[$wasEmployeeAdded]['entries'], $index, 0, $insert );
          $wasEmployeeAdded = -1;
          break;
        }//if employee added
        $wasEmployeeAdded++;
      }//previous data loop finished

      if($wasEmployeeAdded != -1){//was the employee not added?

        array_push($dataArr,[
          'employee_id' => $fetchData->employee_id,
          'full_name' => $fetchData->full_name,
          'entries' => [$fetchData->time],
        ]);
      }


    }//attendance entries finished


    return view('reports.multipleInOut')->with([
      'data' => $dataArr,
      'date' => $request->date,
    ]);

  }



}
