<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpWorkExperience extends Model
{
  protected $table = 'emp_work_experience';

  protected $fillable = [
    'emp_id','work_title','work_description','start','end',
  ];
}
