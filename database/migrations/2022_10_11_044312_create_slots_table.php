<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parking_id');
            $table->boolean('available');
            $table->string('vehicle_plate', 6)->unique()->nullable();
            $table->timestamps();

            $table->foreign('parking_id')->references('id')->on('parkings')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // $table->foreign('vehicle_plate')->references('plate')->on('vehicles')
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slots');
    }
};
