<?php

namespace App\Http\Controllers;
use App\Designations;
use App\Http\Requests\DesignationRequest;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
  public function index(Designations $model)
  {

      return view('designation.index', ['designations' => $model->paginate(15)]);
  }


  public function create()
  {

      return view('designation.create')->with([

      ]);
  }


  public function store(DesignationRequest $request, Designations $model)
  {

      $designation = $model->create($request->all());


      return redirect()->route('designation.index')->withStatus(__('Designation successfully created.'));
  }


  public function edit(Designations $designation)
  {

      return view('designation.edit')->with([
        'designation' => $designation,
      ]);
  }


  public function update(DesignationRequest $request, Designations  $designation)
  {

      $designation->update($request->all());

      return redirect()->route('designation.index')->withStatus(__('Designation successfully updated.'));
  }


  public function destroy(Designations  $designation)
  {

      $designation->delete();

      return redirect()->route('designation.index')->withStatus(__('Designation successfully deleted.'));
  }
}
