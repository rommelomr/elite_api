<?php

namespace App\Classes;

class Responses
{
  
  public static function makeIdentificationTypesArray($identification_types){

    $response = [];

    foreach($identification_types as $value){

      $response[] = [

        'text' => $value->name,
        'value' => $value->id,

      ];

    }
    return $response;
    
  }
  public static function makeServicesArray($services){

    $response = [];

    foreach($services as $value){

      $response[] = [

        'text' => $value->name.' '.$value->price,
        'value' => $value->id,
        'price' => $value->price,

      ];

    }
    return $response;
  }
  public static function makeCarDriversArray($drivers){

    $response = [];
    foreach($drivers as $value){
      $response[] = [
        'text' => $value->user->username,
        'value' => $value->id,
      ];

    }
    return $response;
  }
  public static function makeReservationsArray($reservations){

      $response = [];

      foreach($reservations as $value){

        if(count($value->services) != 0){
          $service = $value->services[0]->id;
        }else{
          $service = null;

        }

        if($value->status == 0){

          $io = 'IN';

        }else if($value->status == 1){

          $io = 'OUT';

        }else if($value->status == 2){

          $io = 'Entregado';

        }else{

          $io = 'Cancelada';

        }
        

        $response[] = [

          'id' => $value->id,

          'client' => $value->client->person->name,

          'phone' => $value->client->person->phone,

          'identification_type' => $value->client->person->identification_type_id,
          
          'identification_card' => $value->client->person->identification_card,
          
          'email' => $value->client->person->email,

          'vehicle' => $value->vehicle->plaque,

          'brand' => $value->vehicle->brand->name,

          'model' => $value->vehicle->model->name,

          'vehicle_color' => $value->vehicle->color,

          'city' => $value->city,

          'service' => $service,

          'reception_terminal' => $value->reception_terminal_id,

          'devolution_terminal' => $value->devolution_terminal_id,

          'reception_date' => $value->reception_date.' '.$value->reception_time,

          'devolution_date' => $value->devolution_date.' '.$value->devolution_time,

          'has_luggage' => $value->has_luggage,

          'flight_number' => $value->flight_number,

          'invoice_required' => $value->invoice_required,

          'payment_method_id' => $value->payment_method_id,

          'receiver_car_driver' => $value->receiver_car_driver_id,

          'devolution_car_driver' => $value->devolution_car_driver_id,

          'status' => $value->status,

          'in_out' => $io,

          'price' => $value->price,
          
          'observation' => $value->observation,

          'paid' => $value->paid,

        ];
      }
      
      return $response;

  }
  public static function makePaymentMethodsArray($payment_methods){

      $response = [];

      foreach($payment_methods as $value){
        $response[] = [
          'text' => $value->name,
          'value' => $value->id
        ];
      }
      
      return $response;

  }

  public static function makeTerminalsArray($terminals){


      $response = [];

      foreach ($terminals as $value) {

        $response[] = [

          'text'    => $value->name,
          'value'   => $value->id,
          
        ];
      }

      return $response;

  }

  public static function makePricesArray($prices){

    $response = [];
    
    foreach ($prices as $value){
      $response[''.$value->id] = $value->price;
    }

    return $response;

  }
  public static function makePricesArray2($prices){

    $response = [];
    
    foreach ($prices as $value){

      $response[] = [
        'id' => $value->id,
        'price' => $value->price,
        'days' => $value->days,
      ];
      
    }

    return $response;


  }

  
}
