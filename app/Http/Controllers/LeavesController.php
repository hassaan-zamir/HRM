<?php

namespace App\Http\Controllers;
use App\Leaves;
use App\Employees;
use App\Http\Requests\LeavesRequest;
use Illuminate\Http\Request;

class LeavesController extends Controller
{
  public function index(Leaves $model)
  {

    return view('leaves.employee.index', ['leaves' => $model->paginate(15)]);
  }


  public function create()
  {
    $employees = Employees::all();
    return view('leaves.employee.create')->with([
      'employees' => $employees
    ]);
  }


  public function store(LeavesRequest $request, Leaves $model)
  {

    $leaves = $model->create($request->all());


    return redirect()->route('leaves.index')->withStatus(__('Leave successfully created.'));
  }


  public function edit(Leaves $leave)
  {

    return view('leaves.employee.edit')->with([
      'leave' => $leave,
    ]);
  }


  public function update(LeavesRequest $request, Leaves  $leaves)
  {
    $leaves->update($request->all());

    return redirect()->route('leaves.employee.index')->withStatus(__('Leave successfully updated.'));
  }


  public function destroy(Leaves  $leave)
  {

    $leave->delete();

    return redirect()->route('leaves.employee.index')->withStatus(__('Leave successfully deleted.'));
  }
}
