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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parking_id');
            $table->unsignedBigInteger('slot_id');
            $table->dateTime('date_entry');
            $table->dateTime('date_departure')->nullable();
            $table->string('vehicle_plate', 6)->unique();
            $table->enum('vehicle_type', ['Car', 'Motorcycle']);
            $table->float('rate_price', 8, 2)->default(0);
            $table->float('total_price', 8, 2)->default(0);
            $table->timestamps();

            $table->foreign('parking_id')->references('id')->on('parkings')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('slot_id')->references('id')->on('slots')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // $table->foreign('vehicle_plate')->references('plate')->on('vehicles')
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');

            // $table->foreign('vehicle_type')->references('name')->on('types')
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
        Schema::dropIfExists('bills');
    }
};
