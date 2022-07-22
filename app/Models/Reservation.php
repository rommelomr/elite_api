<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;

use App\Classes\MailAssistant;

use App\Models\Vehicle;
use App\Models\Brand;
use App\Models\Person;
use App\Models\Client;
use App\Models\VehicleModel;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sendCheckInEmail($data){
      if($data['flight_number'] == null){

        $data['flight_number'] = 'N/A';

      }
      if($data['color'] == null){

        $data['color'] = 'N/A';

      }

      $data = [

        'subject' => 'Comprobante de recogida',
        'destination' => $this->client->person->email,
        'view' => 'check_in_mail',
        'data' => $data

      ];

      $mail = new MailAssistant($data);

      $mail->send();

      return response()->json(['success']);
      
    }
    public static function sendEmail($data){

        if($data['color'] == null){
          $data['color'] = 'No especificado';
        }
        
        $email = env('APP_DEBUG') ? 'rommelmontoya97@gmail.com' : 'reservas@eliteparking.es';

        $data = [
          'subject' => 'Comprobante de reserva',
          'destination' => [$data['email'],$email],
          'view' => 'reservation_mail',
          'data' => [
              'id' => $data['id'],
              'client_name' => $data['client_name'],
              'plaque' => $data['plaque'],
              'branch' => $data['branch'],
              'model' => $data['model'],
              'color' => $data['color'],
              'reception_date' => $data['reception_date'],
              'reception_terminal' => $data['reception_terminal'],
              'devolution_date' => $data['devolution_date'],
              'devolution_terminal' => $data['devolution_terminal'],
              'price' => $data['price'],
              'observation' => $data['observation'],

          ],

          'attach' => storage_path('app/public/pdfs/').'Reservación Elite Parking.pdf',
        ];


        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadView('reservation_mail',$data['data']);

        $pdf->save(storage_path('app/public/pdfs/').'Reservación Elite Parking.pdf');

        $mail = new MailAssistant($data);

        $mail->send();



        return response()->json(['success']);

    }
    public function vehicle(){

      return $this->belongsTo('App\Models\Vehicle');

    }

    public function services(){

      return $this->belongsToMany('App\Models\Service');

    }

    public function client(){

    	return $this->belongsTo('App\Models\Client');

    }
    
    public function reseiverCarDriver(){

    	return $this->belongsTo('App\Models\CarDriver');

    }
    
    public function devolutionCarDriver(){

    	return $this->belongsTo('App\Models\CarDriver');

    }
        
    public function receptionTerminal(){

    	return $this->belongsTo('App\Models\Terminal');

    }
    
    public function devolutionTerminal(){

    	return $this->belongsTo('App\Models\Terminal');

    }
    
    public function paymentMethod(){

    	return $this->belongsTo('App\Models\PaymentMethod');

    }
    public function reservationService(){

      return $this->hasMany('App\Models\ReservationService');

    }

    public function getTerminals(){

        $reservations = Reservation::with([

          'client',
          'vehicle',
          'receptionTerminal',
          'devolutionTerminal',
          'reseiverUser',
          'devolutionUser',
          'paymentMethod',

        ])->paginate(3);

        $response = [];

        foreach($reservations as $value){

          if($value->paymentMethod != null){
            $payment_method = $value->paymentMethod->name;
          }else{
            $payment_method = 'No definido';

          }
          if($value->receiverUser != null){
            $receiver_user = $value->receiverUser->username;
          }else{
            $receiver_user = 'No definido';

          }
          if($value->devolutionUser != null){
            $devolution_user = $value->devolutionUser->username;
          }else{
            $devolution_user = 'No definido';

          }
          if($value->observation != null){
            $observation = $value->observation;
          }else{
            $observation = 'No definido';

          }

          $response[] = [

            'id' => $value->id,

            'client' => $value->client->person->name,

            'vehicle' => $value->vehicle->plaque.': '.$value->vehicle->brand->name.' '.$value->vehicle->model->name,

            'vehicle_color' => $value->vehicle->color,

            'city' => $value->city,

            'reception_terminal' => $value->receptionTerminal->name,

            'devolution_terminal' => $value->devolutionTerminal->name,

            'reception_date' => $value->reception_date.' '.$value->reception_time,

            'devolution_date' => $value->devolution_date.' '.$value->devolution_time,

            'has_luggage' => $value->has_luggage,

            'flight_number' => $value->flight_number,

            'invoice_required' => $value->invoice_required,


            //'payment_method' => $value->paymentMethod->name,
            'payment_method' => $payment_method,

            //'receiver_user' => $value->receiverUser->username,
            'receiver_user' => $receiver_user,

            //'devolution_user' => $value->devolutionUser->username,
            'devolution_user' => $devolution_user,

            //'observation' => $value->observation
            'observation' => $observation,

          ];
        }
        
        return response()->json($reservations);

    }
    public function modify($request){

      if($request->payment_method_id != null){

        $this->payment_method_id = $request->payment_method_id;

      }

      $this->receiver_car_driver_id = $request->receiver_car_driver;

      $this->devolution_car_driver_id = $request->devolution_car_driver;

      if($request->devolution_date != null){

        $this->devolution_date = $request->devolution_date;

      }

      if($request->devolution_time != null){

        $this->devolution_time = $request->devolution_time;

      }

      if($request->city != null){

        $this->city = $request->city;

      }

      if($request->reception_terminal != null){

        $this->reception_terminal_id = $request->reception_terminal;

      }

      if($request->devolution_terminal != null){

        $this->devolution_terminal_id = $request->devolution_terminal;

      }

      $this->has_luggage = $request->has_luggage;

      $this->invoice_required = $request->invoice_required;

      if($request->flight_number != null){

        $this->flight_number = $request->flight_number;

      }

      if($request->status !== null){

        $this->status = $request->status;

      }

      $this->payment_method_id = $request->payment_method_id;
      $this->paid = $request->paid;


      
      
      
    }
    public function modifyVehicle($req){
    
      $is_different = $this->vehicle->plaque != $req->vehicle
        || $this->vehicle->brand->name != $req->brand
        || $this->vehicle->model->name != $req->model
        || $this->vehicle->color != $req->vehicle_color;

      if($is_different){

        $brand = Brand::firstOrCreate([

          'name' => $req->brand

        ]);
        $model = VehicleModel::firstOrCreate([

          'name' => $req->model

        ]);    

        $new_vehicle = Vehicle::create([
          'plaque' => $req->vehicle,
          'brand_id' => $brand->id,
          'model_id' => $model->id,
          'color' => $req->vehicle_color
        ]);

        $this->vehicle_id = $new_vehicle->id;
        $this->save();
      }

    }
    public function someClientDataWasChanged($data){

      return $this->client->person->name != $data->client
        || $this->client->person->phone != $data->phone
        || $this->client->person->email != $data->email
        || $this->client->person->identification_type_id != $data->identification_type
        || $this->client->person->identification_card != $data->identification_card;

    }
    public function updateClient($data){
       
        $this->client->person->name = $data['name'];
        $this->client->person->phone = $data['phone'];
        $this->client->person->email = $data['email'];
        $this->client->person->identification_type_id = $data['identification_type'];
        $this->client->person->identification_card = $data['identification_card'];
        //UPDATE ALL PROPERTIES 
        $this->push();

    }
    public function assignNewClient($data){

      $person = Person::create([
        'name' => $data['name'],
        'phone' => $data['phone'],
        'email' => $data['email'],
        'identification_type_id' => $data['identification_type'],
        'identification_card' => $data['identification_card']
      ]);

      $client = Client::create([
        'person_id' => $person->id
      ]);

      $this->client_id = $client->id;

      $this->save();

    }
}
