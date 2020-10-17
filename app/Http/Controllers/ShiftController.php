<?php

namespace App\Http\Controllers;
use App\Shifts;
use App\Http\Requests\ShiftRequest;
use App\Http\Controllers\HelperController;
use Illuminate\Http\Request;

class ShiftController extends Controller
{

  public function index(Shifts $model)
  {

    return view('shift.index', ['shifts' => $model->paginate(15)]);
  }


  public function create()
  {

    return view('shift.create')->with([

    ]);
  }

  private function createShiftRow(ShiftRequest $request){
    $start_time = new \DateTime();
    $start_time->setTime($request->start_time_hr,$request->start_time_min)->format('H:i:s');
    $dayStartTime = new \DateTime();
    $dayStartTime->setTime($request->day_start_hr,$request->day_start_min)->format('H:i:s');
    $reqArr = [
      'name' => $request->name,
      'user_id' => $request->user_id,
      'description' => $request->description,
      'day_start' => $dayStartTime,
      'start_time' => $start_time,
      'shift_duration' => ($request->duration_hour+($request->duration_mins/60)),
      'lunch_duration' => ($request->lunch_duration_hour+($request->lunch_duration_mins/60)),
      'late_time' => ($request->late_duration_hour+($request->late_duration_mins/60)),
      'early_go_time' => ($request->early_duration_hour+($request->early_duration_mins/60)),
      'overtime_start_time' => ($request->overtime_duration_hour+($request->overtime_duration_mins/60)),
      'sunday_check' => $request->sunday_check,
    ];

    if($request->sunday_check == '2'){
      $sunday_start_time = new \DateTime();
      $sunday_start_time->setTime($request->sunday_start_time_hr,$request->sunday_start_time_min)->format('H:i:s');
      $reqArr['sunday_start_time'] = $sunday_start_time;
      $reqArr['sunday_shift_duration'] = ($request->sunday_duration_hour+($request->sunday_duration_mins/60));
      $reqArr['sunday_lunch_duration'] = ($request->sunday_lunch_duration_hour+($request->sunday_lunch_duration_mins/60));
      $reqArr['sunday_late_time'] = ($request->sunday_late_duration_hour+($request->sunday_late_duration_mins/60));
      $reqArr['sunday_early_go_time'] = ($request->sunday_early_duration_hour+($request->sunday_early_duration_mins/60));
      $reqArr['sunday_overtime_start_time'] = ($request->sunday_overtime_duration_hour+($request->sunday_overtime_duration_mins/60));
    }
    return $reqArr;
  }

  public function store(ShiftRequest $request, Shifts $model)
  {

    $reqArr = $this->createShiftRow($request);

    $shift = $model->create($reqArr);


    return redirect()->route('shift.index')->withStatus(__('Shift successfully created.'));
  }


  public function edit(Shifts $shift)
  {

    return view('shift.edit')->with([
      'shift' => $shift,
    ]);

  }


  public function update(ShiftRequest $request, Shifts  $shift)
  {

    $reqArr = $this->createShiftRow($request);
    $shift->update($reqArr);

    return redirect()->route('shift.index')->withStatus(__('Shift successfully updated.'));
  }


  public function destroy(Shifts  $shift)
  {

    $shift->delete();

    return redirect()->route('shift.index')->withStatus(__('Shift successfully deleted.'));
  }
}
