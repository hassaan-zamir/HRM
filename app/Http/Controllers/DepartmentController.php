<?php

namespace App\Http\Controllers;
use App\Department;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
  public function index(Department $model)
  {
      return view('department.index', ['departments' => $model->paginate(15)]);
  }


  public function create()
  {

      return view('department.create')->with([

      ]);
  }


  public function store(DepartmentRequest $request, Department $model)
  {

      $department = $model->create($request->all());


      return redirect()->route('department.index')->withStatus(__('Department successfully created.'));
  }


  public function edit(Department $department)
  {

      return view('department.edit')->with([
        'department' => $department,
      ]);
  }


  public function update(DepartmentRequest $request, Department  $department)
  {
      
      $department->update($request->all());

      return redirect()->route('department.index')->withStatus(__('Department successfully updated.'));
  }


  public function destroy(Department  $department)
  {

      $department->delete();

      return redirect()->route('department.index')->withStatus(__('Department successfully deleted.'));
  }
}
