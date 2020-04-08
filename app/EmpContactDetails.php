<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpContactDetails extends Model
{
  protected $table = 'emp_contact_details';

  protected $fillable = [
    'emp_id','mobile','mobile2','address',
  ];
}
