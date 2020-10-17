<?php

namespace App\Http\Controllers;

use App\Employees;
use App\EmpContactDetails;
use App\EmpEmergencyDetails;
use App\EmpPersonalDetails;
use App\EmpQualificationDetails;
use App\EmpWorkExperience;
use App\EmpSalaryDetails;
use App\Designations;
use App\Department;
use App\Shifts;

use App\Http\Requests\EmployeeRequest;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

  public function index(Employees $model)
  {
    $employees = Employees::orderBy('machine_id')->get();

    $i = 0;
    foreach ($employees as $emp) {

      //($employees[$i])->department = (Department::where('id','=',$emp->department)->get()->toArray())[0]['name'];
      $dep = Department::where('id','=',$emp->department)->get();
      if(count($dep) > 0){

        $employees[$i]->department = $dep->toArray()[0]['name'];
      }else{
        $employees[$i]->department = 'N/A';
      }

      $i++;
    }

    return view('employee.index')->with([
      'employees' => $employees,
    ]);
  }


  public function create()
  {
    $departments = Department::all();
    $designations = Designations::all();
    return view('employee.create')->with([
      'departments' => $departments,
      'designations' => $designations,
    ]);
  }


  public function store(EmployeeRequest $request,Employees $model)
  {


    $employeeRequest = array(
      'machine_id' => $request->machine_id,
      'full_name' => $request->full_name,
      'designation' => $request->designation,
      'department' => $request->department,
      'join_date' => $request->join_date

    );

    $employee = $model->create($employeeRequest);
    $emp_id = $employee->id;

    $personalRequest = array(
      'emp_id' => $emp_id,
      'nic' => $request->nic,
      'gender' => $request->gender,
      'nationality' => $request->nationality,
      'dob' => $request->dob,
      'nic_expiry' => $request->nic_expiry,
      'marital_status' => $request->marital_status,
      'pic' => $request->pic,
    );

    $personal = EmpPersonalDetails::create($personalRequest);

    $late_early_deductions = $late_penalty = $hourly_overtime_allow = $holiday_overtime_allow = null;
    if(isset($request->late_early_deductions)){
      if($request->late_early_deductions == "on"){
        $late_early_deductions = true;
      }
    }
    if(isset($request->late_penalty)){
      if($request->late_penalty == "on"){
        $late_penalty = true;
      }
    }
    if(isset($request->hourly_overtime_allow)){
      if($request->hourly_overtime_allow == "on"){
        $hourly_overtime_allow = true;
      }
    }
    if(isset($request->holiday_overtime_allow)){
      if($request->holiday_overtime_allow == "on"){
        $holiday_overtime_allow = true;
      }
    }
    $salaryRequest = array(
      'emp_id' => $emp_id,
      'salary' => $request->basic_pay,
      'fuel_allowance'=> $request->fuel_allowance,
      'mobile_allowance' => $request->mobile_allowance,
      'other_allowance' => $request->other_allowance,
      'late_early_deductions' => $late_early_deductions,
      'late_penalty' => $late_penalty,
      'short_duty_hours' => $request->short_duty_hours,
      'hourly_overtime_allow' => $hourly_overtime_allow,
      'holiday_overtime_allow' => $holiday_overtime_allow,
      'monthly_casual_allow' => $request->monthly_casual_allow,
      'monthly_annual_allow' => $request->monthly_annual_allow,
      'total_casual_allow' => $request->total_casual_allow,
      'total_annual_allow' => $request->total_annual_allow,
    );


    $salary = EmpSalaryDetails::create($salaryRequest);

    $contactRequest = array(
      'emp_id' => $emp_id,
      'mobile' => $request->contact_mobile,
      'mobile2' => $request->contact_mobile2,
      'address' => $request->contact_address,
    );

    $contact = EmpContactDetails::create($contactRequest);

    $emergencyRequest = array(
      'emp_id' => $emp_id,
      'relation' => $request->emergency_relation,
      'full_name' => $request->emergency_full_name,
      'contact' => $request->emergency_contact,
    );
    $emergency = EmpEmergencyDetails::create($emergencyRequest);

    $workexpRequest = array();
    for($i=0;$i<count($request->workexp_title);$i++){
      $tmp = array();
      $tmp['emp_id'] = $emp_id;
      $tmp['work_title'] = ($request->workexp_title)[$i];
      $tmp['work_description'] = ($request->workexp_description)[$i];
      $tmp['start'] = ($request->workexp_start)[$i];
      $tmp['end'] = ($request->workexp_end)[$i];
      array_push($workexpRequest,$tmp);
    }
    foreach($workexpRequest as $weReq){
      $workexp = EmpWorkExperience::create($weReq);
    }


    $qualificationsRequest = array();
    for($i=0;$i<count($request->qualifications_title);$i++){
      $tmp = array();
      $tmp['emp_id'] = $emp_id;
      $tmp['qualification_title'] = ($request->qualifications_title)[$i];
      $tmp['qualification_description'] = ($request->qualifications_description)[$i];
      $tmp['start'] = ($request->qualifications_start)[$i];
      $tmp['end'] = ($request->qualifications_end)[$i];
      array_push($qualificationsRequest,$tmp);
    }
    foreach($qualificationsRequest as $qReq){
      $qualifications = EmpQualificationDetails::create($qReq);
    }


    return redirect()->route('employee.index')->withStatus(__('Employee successfully created.'));
  }

  public function edit(Employees $employee)
  {
    $departments = Department::all();
    $designations = Designations::all();
    $emp_id = $employee->id;
    $contactDetails = EmpContactDetails::where('emp_id','=',$emp_id)->get()->toArray();
    $emergencyDetails = EmpEmergencyDetails::where('emp_id','=',$emp_id)->get()->toArray();
    $personalDetails = EmpPersonalDetails::where('emp_id','=',$emp_id)->get()->toArray();
    $qualificationDetails = EmpQualificationDetails::where('emp_id','=',$emp_id)->get()->toArray();
    $workexpDetails = EmpWorkExperience::where('emp_id','=',$emp_id)->get()->toArray();
    $salaryDetails = EmpSalaryDetails::where('emp_id','=',$emp_id)->get()->toArray();

    return view('employee.edit')->with([
      'departments' => $departments,
      'designations' => $designations,
      'employee' => $employee,
      'contactDetails' => $contactDetails,
      'emergencyDetails' => $emergencyDetails,
      'personalDetails' => $personalDetails,
      'qualificationDetails' => $qualificationDetails,
      'workexpDetails' => $workexpDetails,
      'salaryDetails' => $salaryDetails,
    ]);
  }

  public function update(EmployeeRequest $request,Employees  $employee)
  {

    $employee->update(
      $request->all()
    );

    return redirect()->route('employee.index')->withStatus(__('Employee successfully updated.'));
  }

  public function updating(Request $request){


    $employee = Employees::findOrFail($request->employeeId);
    $employeeRequest = array(
      "id" => $employee->id,
      "machine_id" => $request->machine_id,
      "full_name" => $request->full_name,
      "designation" => $request->designation,
      "department" => $request->department,
      "join_date" => $request->join_date,
    );
    $employee->update(
      $employeeRequest
    );

    $contact = EmpContactDetails::where('emp_id','=',$employee->id)->first();

    if($contact){
      $contactRequest = array(
          'id' => $contact->id,
          'emp_id' => $employee->id,
          'mobile' => $request->contact_mobile,
          'mobile2' => $request->contact_mobile2,
          'address' => $request->contact_address,
      );
      $contact->update(
        $contactRequest
      );
    }

    $emergency = EmpEmergencyDetails::where('emp_id','=',$employee->id)->first();
    if($emergency){
      $emergencyRequest = array(
          'id' => $emergency->id,
          'emp_id' => $employee->id,
          'relation' => $request->emergency_relation,
          'full_name' => $request->emergency_full_name,
          'contact' => $request->emergency_contact,
      );
      $emergency->update(
        $emergencyRequest
      );
    }

    $personal = EmpPersonalDetails::where('emp_id','=',$employee->id)->first();
    if($personal){
      $personalRequest = array(
          'id' => $personal->id,
          'emp_id' => $employee->id,
          'nic' => $request->nic,
          'gender' => $request->gender,
          'nationality' => $request->nationality,
          'nic_expiry' => $request->nic_expiry,
          'marital_status' => $request->marital_status,
          'dob' => $request->dob,
          'pic' => $request->pic,
      );
      $personal->update(
        $personalRequest
      );
    }

    $salary = EmpSalaryDetails::where('emp_id','=',$employee->id)->first();

    if($salary){
      $salaryDetails = array(
          'id' => $salary->id,
          'emp_id' => $employee->id,
          'salary' => $request->basic_pay,
          'fuel_allowance' => $request->fuel_allowance,
          'mobile_allowance' => $request->mobile_allowance,
          'other_allowance' => $request->other_allowance,
          'late_early_deductions' => $request->late_early_deductions,
          'late_penalty' => $request->late_penalty,
          'short_duty_hours' => $request->short_duty_hours,
          'hourly_overtime_allow' => $request->hourly_overtime_allow,
          'holiday_overtime_allow' => $request->holiday_overtime_allow,
          'monthly_casual_allow' => $request->monthly_casual_allow,
          'total_annual_allow' => $request->total_annual_allow,
          'total_casual_allow' => $request->total_casual_allow,
          'monthly_annual_allow' => $request->monthly_annual_allow,
      );
      $salary->update(
        $salaryDetails
      );
    }


    return redirect('/employee');


  }

  public function destroy(Employees  $employee)
  {
    $emp_id = $employee->id;
    EmpContactDetails::where('emp_id','=',$emp_id)->delete();
    EmpEmergencyDetails::where('emp_id','=',$emp_id)->delete();
    EmpPersonalDetails::where('emp_id','=',$emp_id)->delete();
    EmpQualificationDetails::where('emp_id','=',$emp_id)->delete();
    EmpWorkExperience::where('emp_id','=',$emp_id)->delete();
    EmpSalaryDetails::where('emp_id','=',$emp_id)->delete();
    $employee->delete();

    return redirect()->route('employee.index')->withStatus(__('Employee successfully deleted.'));
  }
}
