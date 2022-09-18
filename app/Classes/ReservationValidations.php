<?php


namespace App\Classes;

use Illuminate\Support\Facades\Validator;
use App\Models\Service;

class ReservationValidations{

    public static function dayLessThan($before, $after){

        $first = new \DateTime($before);
        $second = new \DateTime($after);

        return $first < $second;
        

    }
    public static function validateDates($req){
/*
        $today = new \DateTime('now');

        $date_one = new \DateTime($req->first_date_input.'T'.$req->first_time_input);

        $date_two = new \DateTime($req->second_date_input.'T'.$req->second_time_input);

        if(!($today < $date_one && $date_one < $date_two)){

        	return true;

        }else{

        	return false;
        }
*/
        
        $date_one = $req->first_date_input.'T'.$req->first_time_input;
        $date_two = $req->second_date_input.'T'.$req->second_time_input;

        return ReservationValidations::dayLessThan('now',$date_one) && ReservationValidations::dayLessThan($date_one,$date_two);

    }

    public static function validateInputs($req){

        $validator = Validator::make($req->all(),[

            'client_full_name' => ['required'],

            'client_phone' => ['regex:/^[0-9()+\- ]+$/'],

            'client_email' => ['email'],

            'client_document_number' => ['required'],

            'plaque' => ['required'],

            'brand' => ['required'],

            'model' => ['required'],

            'color' => ['required'],

            'invoice' => ['boolean'],

            'luggage' => ['boolean'],

            'flight_number' => ['required'],

            'document_type' => ['exists:identification_types,id'],

            'reception_terminal' => ['exists:terminals,id'],

            'devolution_terminal' => ['exists:terminals,id'],

            'services' => ['exists:services,id','nullable'],

            'payment_method' => ['exists:payment_methods,id','required'],

            'city' => ['regex:/^[a-zA-ZñÑ ]+$/','nullable'],

        ]);

        return $validator;
    }

    public static function validateServices($req){

        if($req->services == null){

            return true;

        }else{

            is_array($req->services) ? $services = $req->services : $services = [$req->services];

            $services_array = array_unique($services);

            $count_services_array = count($services_array);

            if($count_services_array === count($services)){

                $db_services = Service::whereIn('id',$services_array)->get();

                if(count($db_services) === $count_services_array){

    		        return true;

                }else{

    		        return false;
                }

            }else{
                return false;
            }
        }
    }

    public static function validate($req){
        /*
    	if(!ReservationValidations::validateDates($req)){

            return (object)[

                'success' => false,

                'error_message' => [['La hora y fecha de recogida y devolucion no son válidas.']]

            ];
            
    	}
        */
        
        
    	$v = ReservationValidations::validateInputs($req);

		if($v->fails()){
            
            return (object)[

                'success' => false,

                'error_message' => $v->errors()

            ];

		}

		if(!ReservationValidations::validateServices($req)){

            return (object)[

                'success' => false,

                'error_message' => [['Los servicios seleccionados no son válidos']]

            ];
		}


        return (object)[

            'success' => true,
            'error_message' => 'Reservación guardada exitosamente'

        ]; 
    }

}