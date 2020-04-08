<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpPersonalDetails extends Model
{
  protected $table = 'emp_personal_details';

  protected $fillable = [
    'emp_id','nic','gender','nationality','nic_expiry','marital_status','dob','pic',
  ];
}
