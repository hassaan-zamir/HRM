<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
      'category','key'
    ];

    public function scopeCategories($query){
      return $query->select('category')->groupBy('category');
    }

    public function scopeFilterByCategory($query,$category){
      return $query->select('*')->where('category','=',$category);
    }
}
