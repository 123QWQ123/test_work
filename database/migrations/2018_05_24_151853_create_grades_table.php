<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->string('id');
            $table->string('title');
            $table->string('engine_desc');
            $table->string('wheel_drive');
            $table->integer('price');
            $table->integer('price_discount');
            $table->string('engine');
            $table->string('transmission');
            $table->string('body');
            $table->json('features');
            $table->json('specifications');
            $table->string('car_id');
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
        Schema::dropIfExists('grades');
    }
}
