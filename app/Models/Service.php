<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reservations(){

    	return $this->belongsToMany('App\Models\Reservation');

    }

    public function clients(){

    	return $this->belongsToMany('App\Models\Client');
    	
    }
    

}
