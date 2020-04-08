<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $table = 'employees';

    protected $fillable = [
      'machine_id','full_name','designation','department','join_date'
    ];

    protected $dates = [
      'join_date',
    ];
}
