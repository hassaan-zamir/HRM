<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpSalaryDetails extends Model
{
  protected $table = 'emp_salary_details';

  protected $fillable = [
    'emp_id',
    'salary',
    'fuel_allowance',
    'mobile_allowance',
    'other_allowance',
    'late_early_deductions',
    'short_duty_hours',
    'late_penalty',
    'hourly_overtime_allow',
    'holiday_overtime_allow',
    'monthly_casual_allow',
    'total_casual_allow',
    'monthly_annual_allow',
    'total_annual_allow',

  ];
}
