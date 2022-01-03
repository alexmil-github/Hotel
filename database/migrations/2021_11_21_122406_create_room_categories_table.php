<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 50)->unique();
            $table->integer('number_of_apartments'); //Количество номеров данной категории в отеле
            $table->integer('guests'); //Количество мест в номере
            $table->integer('square'); //Площадь номера
            $table->integer('number_of_rooms'); //Количество комнат в номере
            $table->string('description', 500); // Описание номера

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
        Schema::dropIfExists('room_categories');
    }
}
