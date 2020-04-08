<?php

namespace App\Http\Controllers;
use App\PublicHolidays;
use App\Http\Requests\PublicHolidaysRequest;
use Illuminate\Http\Request;

class PublicHolidaysController extends Controller
{
  public function index(PublicHolidays $model)
  {

    return view('leaves.public.index', ['publicHolidays' => $model->paginate(15)]);
  }


  public function create()
  {

    return view('leaves.public.create')->with([

    ]);
  }


  public function store(PublicHolidaysRequest $request, PublicHolidays $model)
  {

    $publicHolidays = $model->create($request->all());


    return redirect()->route('publicHolidays.index')->withStatus(__('Holiday successfully created.'));
  }


  public function edit(PublicHolidays $publicHoliday)
  {

    return view('leaves.public.edit')->with([
      'publicHoliday' => $publicHoliday,
    ]);
  }


  public function update(PublicHolidaysRequest $request, PublicHolidays  $publicHolidays)
  {
    $publicHolidays->update($request->all());

    return redirect()->route('publicHolidays.index')->withStatus(__('Holiday successfully updated.'));
  }


  public function destroy(PublicHolidays  $publicHoliday)
  {

    $publicHoliday->delete();

    return redirect()->route('publicHolidays.index')->withStatus(__('Holiday successfully deleted.'));
  }
}
