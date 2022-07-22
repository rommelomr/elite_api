<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function checkInReservation(){

        return $this->hasMany('App\Models\Reservation','reception_terminal_id');

    }

    public function checkOutReservation(){

        return $this->hasMany('App\Models\Reservation','devolution_terminal_id');

    }

}
