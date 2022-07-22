<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->string('plaque',12);

            $table->unsignedBigInteger('brand_id');
            
            $table->foreign('brand_id')->references('id')->on('brands');

            $table->unsignedBigInteger('model_id');
            
            $table->foreign('model_id')->references('id')->on('models');

            $table->string('color',20)->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}
