<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\MailAssistant;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    public function displayWelcomePage(){
    	return view('welcome');
    }
    public function spa(){
    	return view('spa');
    }
	public function getIdentificationTypes(){

        $types = DB::table('identification_types')->select(['id','name'])->get();

        //$types should be modified with this format:
        /*
            [
                [ "Text"=>"identification_name", "value"=> identification_id],
                [ "Text"=>"identification_name", "value"=> identification_id],
                [ "Text"=>"identification_name", "value"=> identification_id]
            ]
        */

        return response()->json($types);

    }    
    public function sendReservationEmail(Request $request){



        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadView('reservation_mail');

        $pdf->save(storage_path('app/public/pdfs/').'Reservación Elite Parking.pdf');

        $mail = new MailAssistant([
            'subject' => 'Test',
            //'destination' => 'morpk69@gmail.com',
            'destination' => 'rommelmontoya97@gmail.com',
            'view' => 'reservation_mail',
            'data' => [
                'client_name' => '',
                'plaque' => '',
                'branch' => '',
                'model' => '',
                'color' => '',
                'driver_name' => '',
                'driver_email' => '',
                'reception_date' => '',
                'reception_terminal' => '',
                'devolution_date' => '',
                'devolution_terminal' => '',
            ],

            'attach' => storage_path('app/public/pdfs/').'Reservación Elite Parking.pdf',
        ]);

        $mail->send();

        return response()->json(['success']);
    }    
}
