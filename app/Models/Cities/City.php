<?php

namespace App\Models\Cities;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
