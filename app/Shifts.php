<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shifts extends Model
{
  protected $table = 'shifts';

  protected $fillable = [
    'name',
    'user_id',
    'description',
    'day_start',
    'start_time',
    'shift_duration',
    'lunch_duration',
    'late_time',
    'early_go_time',
    'overtime_start_time',
    'sunday_check',
    'sunday_start_time',
    'sunday_shift_duration',
    'sunday_lunch_duration',
    'sunday_late_time',
    'sunday_early_go_time',
    'sunday_overtime_start_time',
  ];

}
