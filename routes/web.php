<?php


Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['register' => false,]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {


	Route::resource('user', 'UserController', ['except' => ['show']]);
  Route::resource('employee','EmployeeController');
  Route::post('/employee/updating','EmployeeController@updating')->name('employees.updating');
  Route::resource('shift','ShiftController');
  //roster
  Route::get('roster','RosterController@index')->name('roster.index');
  Route::post('addToRoster','RosterController@addToRoster')->name('roster.add');
  Route::get('loadRoster','RosterController@loadRoster')->name('roster.load');
  Route::get('rosterResources','RosterController@rosterResources')->name('roster.resources');

  Route::resource('publicHolidays','PublicHolidaysController');
  Route::resource('leaves','LeavesController');
  Route::resource('department','DepartmentController');
  Route::resource('designation','DesignationController');

  Route::get('/attendance', 'AttendanceController@index')->name('attendance.index');
  Route::post('/attendance','AttendanceController@view')->name('attendance.view');
  Route::post('/saveAttendanceChanges','AttendanceController@saveChanges')->name('attendance.changes');
  Route::get('/importAttendance','AttendanceController@importFront')->name('attendance.importfront');
  Route::post('/importAttendance','AttendanceController@import')->name('attendance.import');

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);


  Route::get('/reports/monthly/timeregister','ReportsController@monthlyTimeRegisterFront')->name('reports.time_register_front');
  Route::post('/reports/monthly/timeregister/','ReportsController@monthlyTimeRegister')->name('reports.time_register');
  Route::get('/reports/monthly/employee','ReportsController@monthlyEmployeeFront')->name('reports.employee_report_front');
  Route::post('/reports/monthly/employee/','ReportsController@monthlyEmployeeReport')->name('reports.employee_report');
  Route::get('/reports/multiple_in_out/','ReportsController@multipleInOutFront')->name('reports.multiple_in_out_front');
  Route::post('/reports/multiple_in_out/','ReportsController@multipleInOut')->name('reports.multiple_in_out');


});
