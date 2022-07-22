<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('client_id');
            
            $table->foreign('client_id')->references('id')->on('clients');

            $table->unsignedBigInteger('vehicle_id');
            
            $table->foreign('vehicle_id')->references('id')->on('vehicles');

            $table->unsignedBigInteger('receiver_car_driver_id')->nullable();
            
            $table->foreign('receiver_car_driver_id')->references('id')->on('car_drivers');

            $table->unsignedBigInteger('devolution_car_driver_id')->nullable();
            
            $table->foreign('devolution_car_driver_id')->references('id')->on('car_drivers');

            $table->unsignedBigInteger('payment_method_id')->nullable();
            
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');

            $table->string('city',50)->nullable();

            $table->unsignedBigInteger('reception_terminal_id');
            
            $table->foreign('reception_terminal_id')->references('id')->on('terminals');

            $table->unsignedBigInteger('devolution_terminal_id');
            
            $table->foreign('devolution_terminal_id')->references('id')->on('terminals');

            $table->date('reception_date');
            $table->time('reception_time');

            $table->date('devolution_date');
            $table->time('devolution_time');

            $table->tinyInteger('has_luggage');

            $table->string('flight_number',16)->nullable();

            $table->tinyInteger('invoice_required');

            $table->tinyInteger('status')->default(0);

            $table->string('observation',255)->nullable();

            $table->decimal('price',5,2);
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
