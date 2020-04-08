<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = ['employee_id','time','manual_overtime'];

    protected $dates = ['time'];
}
