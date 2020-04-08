<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpEmergencyDetails extends Model
{
  protected $table = 'emp_emeregency_contact';

  protected $fillable = [
    'emp_id','relation','full_name','contact',
  ];
}
