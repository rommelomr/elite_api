<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function person(){

        return $this->belongsTo('App\Models\Person');

    }

    public function reservations(){

        return $this->hasMany('App\Models\Reservation');

    }

}
