<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use HasFactory;

    protected $table = 'models';
    protected $guarded = [];

    public function vehicle(){

    	return $this->hasMany('App\Models\Vehicle');

    }
    
}
