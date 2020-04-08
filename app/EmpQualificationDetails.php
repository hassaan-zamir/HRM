<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpQualificationDetails extends Model
{
  protected $table = 'emp_qualifications';

  protected $fillable = [
    'emp_id','qualification_title','qualification_description','start','end',
  ];
}
