<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Terminal;
use App\Classes\Responses;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function homeData(){

    	$terminals = Terminal::all();

        $terminals = Responses::makeTerminalsArray($terminals);

    	$prices = DB::table('prices')->get();

    	$prices = Responses::makePricesArray($prices);

    	return [
    		'terminals' => $terminals,
    		'prices' => $prices
    	];


    }
}
