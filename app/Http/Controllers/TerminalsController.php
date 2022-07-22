<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Terminal;
use App\Classes\Responses;

class TerminalsController extends Controller
{
 
	public function getTerminals(){

		return Responses::makeTerminalsArray(Terminal::all());
		
	}

}
