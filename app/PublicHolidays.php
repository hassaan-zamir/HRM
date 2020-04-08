<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PublicHolidays extends Model
{
    protected $table = 'public_holidays';

    protected $fillable = [
      'date','title','description'
    ];
}
