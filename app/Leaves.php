<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leaves extends Model
{
    protected $table = 'leaves';

    protected $fillable = [
      'start_date','end_date','emp_id','user_id','subject','description','type'
    ];
}
