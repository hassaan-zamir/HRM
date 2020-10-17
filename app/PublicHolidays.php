<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PublicHolidays extends Model
{
    protected $table = 'public_holidays';

    protected $fillable = [
      'date','title','description'
    ];

    public function getDateAttribute($value){
      return Carbon::parse($value)->format('Y/m/d');
    }
}
