<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    protected $table = 'roster';

    protected $fillable = [
      'start','end','employee_id','roster_shift_id','user_id',
    ];

    protected $dates = [
      'start','end'
    ];
}
