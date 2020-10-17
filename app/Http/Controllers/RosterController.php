<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RosterShifts;
use App\Shifts;
use App\Department;
use App\Employees;
use App\Roster;
use Carbon\Carbon;

class RosterController extends Controller
{
  public function index(){

    $shifts = Shifts::all();
    $departments = Department::all();
    $employees = Employees::all();

    return view('roster.index')->with([
      'shifts' => $shifts,
      'departments' => $departments,
      'employees' => $employees,
    ]);
  }



  public function loadRoster(Request $request){


    if($request->date){
      if($request->date == 1){
        $date = Carbon::now();
      }else{
        $date = Carbon::parse($request->date);
      }


      $data = array();

      $employees = Employees::all();
      foreach($employees as $employee){
        $row = array();
        $row['employee'] = $employee;
        $row['dates'] = array();
        $start = $date->copy()->startOfMonth();
        $end = $date->copy()->endOfmonth();
        while($start <= $end){

          $roster = Roster::where('employee_id',$employee->id)->where('start','<=',$start)->where('end','>=',$start)->latest()->get();
          if(count($roster) > 0){
            $roster = $roster[0];
            $shift = RosterShifts::find($roster->roster_shift_id)->name;

          }else{
            $shift = 'N/A';
          }
          array_push($row['dates'],['date' => $start->day , 'day' => HelperController::dayOfWeekShort($start->dayOfWeek), 'shift' => $shift]);
          $start->addDays(1);
        }
        array_push($data,$row);
      }
      return view('roster.view')->with([
        'data' => $data,
      ]);

    }else{
      return '<h2 style="color:red;">Unexpected Error Occured While Loading Roster</h2>';
    }


    $roster = Roster::join('roster_shifts','roster.roster_shift_id','=','roster_shifts.id')->
    select('roster.id','roster.start','roster.end','roster_shifts.name as text','roster_shifts.description','roster.employee_id','roster.dep_id')->get();

    dd($roster);
    $returnArr = [];
    //foreach roster entry
    foreach ($roster as $item) {

      $employee_ids = $item->employee_id;

      $track = 0; //identifier to check if single employee or multiple
      if($employee_ids == "0"){

        if($item->dep_id == "0"){
          $track = 1;
          $employee_ids = Employees::select('id')->get()->toArray();
        }else{
          $track = 1;
          $employee_ids = Employees::select('id')->whereIn('department',explode(',',$item->dep_id))->get()->toArray();
        }

      }else{
        $employee_ids = explode(',',$employee_ids);
      }
      //foreach employee in an roster entry

      foreach($employee_ids as $employee_id){

        if($track == 1){
          $employee_id = $employee_id['id'];
        }
        $starting = $item->start;
        $ending = $item->end;
        while($starting <= $ending){
          $currDate = $starting;

          $date = (explode(' ',implode('_',explode('-',$currDate->toDateTimeString())) )[0]);
          $alreadyExist = 0;
          foreach($returnArr as $checkAgainst){

            if($checkAgainst['resource'] == 'e'.$employee_id && $currDate==Carbon::parse($checkAgainst['start']) && $currDate==Carbon::parse($checkAgainst['end']) ){

              $returnArr[$alreadyExist]['id'] = $item->id.'_'.$employee_id.'_'.$date;
              $returnArr[$alreadyExist]['text'] =  '<span style="text-align:center;width:100%;">'.$item->text.'</span>';
              $alreadyExist = -1;
              break;
            }
            $alreadyExist++;
          }
          if($alreadyExist >= 0){
            array_push($returnArr,[
              'id' => $item->id.'_'.$employee_id.'_'.$date,
              'resource' => "e".$employee_id,
              'start' => $currDate->toDateTimeString(),
              'end' => $currDate->toDateTimeString(),
              'text' => '<span style="text-align:center;width:100%;">'.$item->text.'</span>',
            ]);
          }
          $starting = $starting->addDays(1);
        }

      }

    }
    return json_encode($returnArr);
  }

  public function addToRoster(Request $request){


    $returnArr = [
      'status' => 'Faliure',
      'message' => 'Roster could not be saved due to unkwon reasons! try again later',
    ];


    if(strpos($request->daterange," - ") == false){
      $returnArr['message'] = 'Invalid Date Range Format';
    }else{

      $daterange = explode(" - ",$request->daterange);
      if(!isset($daterange[0]) || !isset($daterange[1]) ){
        $returnArr['message'] = 'Invalid Date Range Format';
      }else if(!isset($request->shift) || empty($request->shift)){
        $returnArr['message'] = 'You must select a shift';
      }else if( !isset($request->selection)  || empty($request->selection)  || count($request->selection)== 0 ){
        $returnArr['message'] = 'You must atleast one Department';
      }else if( !isset($request->selection2)  || empty($request->selection2)  || count($request->selection2)== 0 ){
        $returnArr['message'] = 'You must atleast one Employee';
      }else{

        //Shifts Id Cannot Be Passed On as roster should not be changed on shift change
        //Also Duplication Shifts Data For every entry is also a bad idea
        //So Duplicating but only when already not duplicated (Duplicated data is non editable/deletable)
        $shift_id = $request->shift;
        $shift = Shifts::findOrFail($shift_id);
        $findSimilar = RosterShifts::where([
          ['name','=',$shift->name],
          ['description','=',$shift->description],
          ['day_start','=',$shift->day_start],
          ['start_time','=',$shift->start_time],
          ['shift_duration','=',$shift->shift_duration],
          ['lunch_duration','=',$shift->lunch_duration],
          ['late_time','=',$shift->late_time],
          ['early_go_time','=',$shift->early_go_time],
          ['overtime_start_time','=',$shift->overtime_start_time],
          ['sunday_check','=',$shift->sunday_check],
          ['sunday_start_time','=',$shift->sunday_start_time],
          ['sunday_shift_duration','=',$shift->sunday_shift_duration],
          ['sunday_lunch_duration','=',$shift->sunday_lunch_duration],
          ['sunday_late_time','=',$shift->sunday_late_time],
          ['sunday_early_go_time','=',$shift->sunday_early_go_time],
          ['sunday_overtime_start_time','=',$shift->sunday_overtime_start_time]
          ])->get();

          if( count($findSimilar) > 0){
            $roster_shift_id = $findSimilar[0]->id;
          }else{

            $roster_shift_id = RosterShifts::create([
              'name' => $shift->name,
              'description' => $shift->description,
              'day_start' => $shift->day_start,
              'start_time' => $shift->start_time,
              'shift_duration' => $shift->shift_duration,
              'lunch_duration' => $shift->lunch_duration,
              'late_time' => $shift->late_time,
              'early_go_time' => $shift->early_go_time,
              'overtime_start_time' => $shift->overtime_start_time,
              'sunday_check' => $shift->sunday_check,
              'sunday_start_time' => $shift->sunday_start_time,
              'sunday_shift_duration' => $shift->sunday_shift_duration,
              'sunday_lunch_duration' => $shift->sunday_lunch_duration,
              'sunday_late_time' => $shift->sunday_late_time,
              'sunday_early_go_time' => $shift->sunday_early_go_time,
              'sunday_overtime_start_time' => $shift->sunday_overtime_start_time,
            ]);
            $roster_shift_id = $roster_shift_id->id;
          }


          if(count($request->selection2) > 0){
            $employee_ids = $request->selection2;
            if($employee_ids[0] == "0" && count($request->selection) > 0 ){//if all Employees
              $dep_ids = $request->selection;
              if($dep_ids[0] == "0"){ // if all department
                $dep_ids = Department::all()->pluck('id')->toArray();
              }
              $employee_ids = Employees::whereIn('department',$dep_ids)->pluck('id')->toArray();
            }


            foreach ($employee_ids as $employee_id){

              $req = [
                'start' => Carbon::parse($daterange[0]),
                'end' => Carbon::parse($daterange[1]),
                'roster_shift_id' => $roster_shift_id,
                'employee_id' => $employee_id,
                'user_id' => \Auth::id(),
              ];

              if(Roster::create($req)){
                $returnArr['status'] = 'Success';
                $returnArr['message'] = 'Roster Saved Successfully!';
              }else{
                $returnArr['status'] = 'Faliure';
                $returnArr['message'] = 'Roster Could Not be Saved due to unkown reasons! Try again later.';
              }

            }
          }

        }

      }

      return json_encode($returnArr);
    }
  }
