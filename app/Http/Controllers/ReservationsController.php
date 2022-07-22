<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Classes\ReservationValidations;

use App\Models\Reservation;
use App\Models\TPVTransaction;
use App\Models\IdentificationType;
use App\Models\ReservationService;
use App\Classes\Responses;
use App\Classes\RedsysAPI;
use App\Models\Person;
use App\Models\Brand;
use App\Models\VehicleModel;
use App\Models\Client;
use App\Models\Vehicle;
use App\Models\Terminal;
use App\Models\City;
use App\Models\CarDriver;
use App\Models\PaymentMethod;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ReservationsController extends Controller
{
    public function modifyReservation(Request $request){

      $request->validate([
        //Telefono
        //Mail
        //Document type
        //Document number

        'id' => ['exists:reservations,id','required'],

        'client' => ['required','regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/'],

        'vehicle' => ['required','regex:/^[a-zA-Z0-9ñÑ-]+$/'],

        'brand' => ['required','regex:/^[a-zA-Z0-9ñÑ ]+$/'],

        'model' => ['required','regex:/^[a-zA-Z0-9ñÑ ]+$/'],

        'vehicle_color' => ['regex:/^[a-zA-ZñÑ ]+$/','nullable'],

        'invoice_required' => ['boolean'],

        'has_luggage' => ['boolean'],

        'flight_number' => ['regex:/^[a-zA-Z0-9ñÑ-]+$/','nullable'],

        'reception_terminal' => ['exists:terminals,id'],

        'devolution_terminal' => ['exists:terminals,id'],

        'city' => ['regex:/^[a-zA-ZñÑ ]+$/','nullable'],

        'payment_method_id' => ['nullable','exists:payment_methods,id'],

        'receiver_car_driver' => ['exists:car_drivers,id','nullable'],

        'devolution_car_driver' => ['exists:car_drivers,id','nullable'],

        'status' => ['in:0,1,2,3'],

        'paid' => ['in:0,1'],

      ]);


      $reservation = Reservation::with(['vehicle'=>function($query){

        $query->with(['brand','model']);

      }
      ,'client'=>function($query){

        $query->with('person');

      }])->find($request->id);

      $old_status = $reservation->status;

      $reservation->modifyVehicle($request);
      $reservation->modify($request);
      $reservation->services()->sync($request->service);
      $reservation->observation = $request->observation;      
      
      if(($request->status != $old_status) && ($request->status == 1)){

          $reservation->sendCheckInEmail([
            'client' => $request->client,
            'plaque' => $request->vehicle,
            'reservation_date' => $reservation->reception_date.' '.$reservation->reception_time,
            'devolution_date' => $reservation->devolution_date.' '.$reservation->devolution_time,
            'flight_number' => $request->flight_number,
            'brand' => $request->brand,
            'model' => $request->model,
            'color' => $request->color
          ]);

      }

      $reservation->save();
      
      return response()->json([
        'messages' => [
          'Reservación modificada'
        ]
      ]);

    }
    public function reservations(Request $request){


      
      $reservations = Reservation::with([

        'client',
        'vehicle',
        'services',
        'reseiverCarDriver' => function($query){

          $query->with('user');

        },
        'devolutionCarDriver' => function($query){

          $query->with('user');

        },
        'paymentMethod',

      ])->orderBy('created_at','desc');
      $auth = \Auth::user();
      
      if($request->search != null){

        $reservations->where('id','like','%'.$request->search.'%')
        ->orWhereHas('vehicle',function($query)use($request){
          $query->where('plaque','like','%'.$request->search.'%');
        })
        ->orWhereHas('client',function($query)use($request){
          $query->whereHas('person',function($query)use($request){
            $query->where('name','like','%'.$request->search.'%');
          });
        })
        ->orWhere('devolution_date','like','%'.$request->search.'%')
        ->orWhere('reception_date','like','%'.$request->search.'%');


      }
      if($auth->role == 'C'){
        $reservations->where('status','<',2)

        ->where(function($query)use($auth){

            $query->where(function($query)use($auth){
              $query->where('receiver_car_driver_id',$auth->carDriver->id)
                    ->where('devolution_car_driver_id',$auth->carDriver->id);
            })
            ->orWhere(function($query)use($auth){
              $query->where('receiver_car_driver_id',$auth->carDriver->id)
                    ->where('status',0);
            })
            ->orWhere(function($query)use($auth){
              $query->where('devolution_car_driver_id',$auth->carDriver->id)
                    ->where('status',1);
            });

            
            

          });

      }

      $reservations = $reservations->paginate($request->rows);

      $reservations_array = Responses::makeReservationsArray($reservations);

      $payment_methods = PaymentMethod::all();

      $payment_methods_array = Responses::makePaymentMethodsArray($payment_methods);

      $services = Service::all();

      $services_array = Responses::makeServicesArray($services);

      $drivers = CarDriver::with(['user'])->get();

      $drivers_array = Responses::makeCarDriversArray($drivers);

      $identification_types = IdentificationType::get();

      $identification_types_array = Responses::makeIdentificationTypesArray($identification_types);

      $terminals = Terminal::all();

      $terminals = Responses::makeTerminalsArray($terminals);

      $response = [

        'reservations' => $reservations_array,
        'payment_methods' => $payment_methods_array,
        'paginate' => $reservations,
        'services' => $services_array,
        'terminals' => $terminals,
        'drivers' => $drivers_array,
        'identification_types' => $identification_types_array

      ];
      return response()->json($response);

    }
    public function saveReservation(Request $req){

      $validations = ReservationValidations::validate($req);

      if($validations->success){
      

        $person = Person::firstOrCreate([

          'identification_type_id' => $req->document_type,

          'identification_card' => $req->client_document_number,

        ],[

          'name' => $req->client_full_name,

          'phone' => $req->client_phone,

          'email' => $req->client_email

        ]);
      

        $client = Client::firstOrCreate([

          'person_id' => $person->id

        ]);

        $brand = Brand::firstOrCreate([

          'name' => $req->brand

        ]);
        $model = VehicleModel::firstOrCreate([

          'name' => $req->model

        ]);        

        $vehicle = Vehicle::firstOrCreate([

          'plaque' => $req->plaque

        ],[

          'brand_id' => $brand->id,
          'model_id' => $model->id,
          'color' => $req->color,

        ]);

        //OJO AQUI HAY QUE VALIDAR QUE LA FECHA DOS SEA MAYOR A LA UNO

        $date_one = new \DateTime($req->first_date_input.'T'.$req->first_time_input);
        $date_two = new \DateTime($req->second_date_input.'T'.$req->second_time_input);
        $diff = $date_one->diff($date_two)->days;
        $prices = DB::table('prices')->get();

        if($diff > 30){

          $price = $prices[30]->price + (($diff - 31) * 5);

        }else{

          $price = $prices[$diff]->price;

        }

        //Guardar Reserva

        $reservation = Reservation::create([

          'client_id' => $client->id,
          'vehicle_id' => $vehicle->id,
          'city' => $req->city,
          'reception_terminal_id' => $req->reception_terminal,
          'devolution_terminal_id' => $req->devolution_terminal,
          'reception_date' => $req->first_date_input,
          'reception_time' => $req->first_time_input,
          'devolution_date' => $req->second_date_input,
          'devolution_time' => $req->second_time_input,
          'has_luggage' => $req->luggage,
          'flight_number' => $req->flight_number,
          'invoice_required' => $req->invoice,
          'observation' => $req->observation,
          'price' => $price,
          'payment_method_id' => $req->payment_method,
          'observation' => $req->observation,

        ]);
        $price_service = 0;

        if($req->services != null){


          $new_service = Service::find($req->services);

          $reservation_service = [

            'reservation_id' => $reservation->id,

            'service_id' => $new_service->id

          ];

          ReservationService::insert($reservation_service);

          $price_service = (float)$new_service->price;
          
        }
        Reservation::sendEmail([
          'id' => $reservation->id,
          'client_name' => $person->name,
          'email' => $person->email,
          'plaque' => $vehicle->plaque,
          'branch' => $brand->name,
          'model' => $model->name,
          'color' => $vehicle->color,
          'reception_date' => $req->first_date_input.' '.$req->first_time_input,
          'reception_terminal' => $req->reception_terminal,
          'devolution_date' => $req->second_date_input.' '.$req->second_time_input,
          'devolution_terminal' => $req->devolution_terminal,
          'price' => $price + $price_service,
          'observation' => $req->observation,
        ]);

        $response = [
          'tpv_request' => false,
          'status' => 1,
          'reservation' => [
            'id' => $reservation->id
          ],
          'messages' => [
            'Reservación guardada satisfactoriamente'

          ],
        ];

        if($req->payment_method == 5){
          //payment_method 5 corresponds to pay by bank
          //If user selects this option, the server send to the front project
          //a specific url for redirect to te bank page

          $response['tpv_request'] = true;

          $ds_merchant = new RedsysAPI;

          $order=rand(1000,9999).$reservation->id;

          $amount = number_format((float)($price + $price_service),2,'.','');
          $amount = explode('.',$amount);
          $amount = $amount[0].$amount[1];


          $ds_merchant->setParameter("DS_MERCHANT_AMOUNT","$amount");

          $ds_merchant->setParameter("DS_MERCHANT_ORDER",$order);

          $ds_merchant->setParameter("DS_MERCHANT_MERCHANTCODE",env('REDSYS_MERCHANT_CODE'));

          $ds_merchant->setParameter("DS_MERCHANT_CURRENCY",'978');

          $ds_merchant->setParameter("DS_MERCHANT_TRANSACTIONTYPE",'0');

          $ds_merchant->setParameter("DS_MERCHANT_TERMINAL",'1');

          $ds_merchant->setParameter("Ds_Merchant_MerchantData",str_replace('"', "'", json_encode(['reservation_id'=>"$reservation->id"])));

          $ds_merchant->setParameter("DS_MERCHANT_MERCHANTURL",'https://eliteparking.es:8000/complete_virtual_tpv_transaction');

          $ds_merchant->setParameter("DS_MERCHANT_URLOK",'https://eliteparking.es/confirmacion_reservacion?success=1');

          $ds_merchant->setParameter("DS_MERCHANT_URLKO",'https://eliteparking.es/confirmacion_reservacion?success=0');

          $response['ds_signature_version'] = 'HMAC_SHA256_V1';
          
          $response['ds_signature'] = $ds_merchant->createMerchantSignature(env('REDSYS_MERCHANT_SIGNATURE'));

          $response['ds_merchant_parameters'] = $ds_merchant->createMerchantParameters();

        }

        return response()->json($response);

      }else{
        //Devolver mensaje de error
        return response()->json([
          'status' => 0,
          'messages' => [
            $validations->error_message
          ],          
        ]);
      }
    }

    public function completeVirtualTPVTransaction(Request $request){

      $merchant_parameters = urldecode(base64_decode($request->Ds_MerchantParameters));

      $f = fopen(base_path('tpv_transactions_log.txt'),'a');
      fwrite($f,$merchant_parameters.PHP_EOL);
      fwrite($f,'__________'.PHP_EOL.PHP_EOL);
      fclose($f);

      $merchant_parameters_decoded = json_decode($merchant_parameters);

      if(strtolower(gettype($merchant_parameters_decoded)) == 'object'){

        $tpv_transaction = new TPVTransaction();
        $tpv_transaction->ds_signature = $request->Ds_Signature;
        $tpv_transaction->ds_merchant_parameters = $request->Ds_MerchantParameters;
        $tpv_transaction->ds_signature_version = $request->Ds_SignatureVersion;

        $reservation = json_decode(str_replace("'",'"',$merchant_parameters_decoded->Ds_MerchantData));

        if(strtolower(gettype($reservation)) == 'object'){
          $reservation_id = $reservation->reservation_id;
          unset($reservation);

          if(is_numeric($reservation_id)){

            $reservation = Reservation::find($reservation_id);

            $reservation == null;

            if($reservation !== null){

                if($merchant_parameters_decoded->Ds_Response <= 99){

                  $reservation->paid = 1;
                  $reservation->save();

                  //transaccion realizada con exito
                  $tpv_transaction->status = 1;

                }else{

                  //Transaccion rechazada por el banco
                  $tpv_transaction->status = 3;
                }

            }else{
              //No se ha encontrado una reservación para esta transacción
              $tpv_transaction->status = 2;

            }

          }else{
            //el valor que llega como id no es un numero
            $tpv_transaction->status = 4;
          }


        }else{
          //El parámetro Ds_MerchantData no es un JSON o el JSON que llega es diferente al esperado
          $tpv_transaction->status = 0;
        }
        $tpv_transaction->save();
      }else{
        $f = fopen(base_path('responses.txt'),'a');
        fwrite($f, 'fecha: '.date('Y-m-d H:i:s').PHP_EOL);
        fwrite($f,'Ds_MerchantParameters proveniente del POST de Redsys no contiene un objeto codificado en base64, han cambiado el formato de la notificación o alguna funcion propia de php que está siendo usada para decodificar no está funcionando correctamente'.PHP_EOL);
        fwrite($f,'_______________'.PHP_EOL.PHP_EOL);
        fclose($f);
      }

      
    }

    public function getReservationFormData(){

      $prices = DB::table('prices')->select(['id','price'])->get();

      $prices = Responses::makePricesArray($prices);

      $services = Service::all();

      $services = Responses::makeServicesArray($services);

      $payment_methods = PaymentMethod::all();

      $payment_methods = Responses::makePaymentMethodsArray($payment_methods);

      return [

        'prices' => $prices,

        'payment_methods' => $payment_methods,

        'services' => $services
        
      ];
    }
    public function generatePdfReservation($id){

      $reservation = Reservation::with([
        'vehicle',
        'client'=>function($query){
          $query->with(['person'=>function($query){
            $query->with('identificationType');
          }]);

        },
        'paymentMethod'
      ])->find($id);

      if($reservation->city == null){
        $reservation->city = 'No especificado';
      }

      if($reservation->observation == null){
        $reservation->observation = 'No especificado';
      }
      
      if($reservation->flight_number == null){
        $reservation->flight_number = 'No especificado';
      }

      if($reservation->vehicle->color == null){
        $reservation->vehicle->color = 'No especificado';
      }
      
      if(count($reservation->services) != 0){
        $reservation->price += $reservation->services[0]->price;
      }

      $pdf = \App::make('dompdf.wrapper');

      $pdf->loadView('payroll',[
        'reservation' => $reservation
      ]);
      
      return $pdf->stream();

    }
    public function updateReservationClient(Request $request){
    /*
      return 
        0: Data don't modified
        1: Actualization success
        2: New client assigned
        3: Identification (card and type) already in use
    */
      $reservation = Reservation::with(['client'=>function($query){

        $query->with('person');

      }])->find($request->id);

      

      if($reservation != null){

        if($reservation->someClientDataWasChanged($request)){

          $data = [
            'name' => $request->client,
            'phone' => $request->phone,
            'email' => $request->email,
            'identification_type' => $request->identification_type,
            'identification_card' => $request->identification_card,
          ];

          $person = Person::where('identification_type_id',$data['identification_type'])
            ->where('identification_card',$data['identification_card']);

          //update reservation client
          if($request->action == 1){


            $person = $person->with('client')->first();
            if(($person==null) || (($person!=null) && ($person->client->id == $reservation->client_id))){

              $reservation->updateClient($data);
              return 1;

            }else{

              return 3;
            }

          //Asign a new client to the reservation
          }else if($request->action == 2){


              
            $person = $person->first();

            if($person == null){

              $reservation->assignNewClient($data);
              return 2;
            }else{

              //
              return 3;
            }

          }

        }else{

          return 0;
        }



      }


    }
}
