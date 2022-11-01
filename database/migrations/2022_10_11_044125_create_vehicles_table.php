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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->string('plate', 6)->primary();
            $table->string('color', 20);
            $table->enum('type', ['Car', 'Motorcycle']);
            $table->string('owner_id', 10);
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('owners')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('type')->references('name')->on('types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
};
