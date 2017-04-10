<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boot_setting extends Model
{
    protected $fillable = [
    'model','address','ch','speed','circuit','token','created_at','updated_at',
  ];
}
