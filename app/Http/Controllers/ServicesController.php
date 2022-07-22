<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Classes\Responses;

class ServicesController extends Controller
{

    public function getServices(){

    	$services = Service::select(['id','name','price'])->get();

    	return response()->json($services);
    }
}
