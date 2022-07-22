<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';
    protected $guarded = [];

    public function identificationType(){

        return $this->belongsTo('App\Models\IdentificationType');

    }

    public function client(){

        return $this->hasOne('App\Models\Client');

    }
	

}
