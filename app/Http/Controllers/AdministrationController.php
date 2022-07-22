<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Classes\Responses;
use Illuminate\Support\Facades\DB;

class AdministrationController extends Controller
{
  public function getPricesViewData(){

    $prices = DB::table('prices')->get();
    $prices = Responses::makePricesArray2($prices);
    return $prices;

  }
  public function updatePrice(Request $request){

    $response = DB::table('prices')
    ->where('id',$request->id)
    ->update(['price'=>$request->price]);
    
    return ['status'=>$response];

  }
}
