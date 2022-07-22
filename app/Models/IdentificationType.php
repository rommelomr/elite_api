<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentificationType extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function personas(){

    	return $this->hasMany('App\Models\Persona');

    }    
}
