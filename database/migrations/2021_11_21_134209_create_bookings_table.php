<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8);
            $table->date('arr_date'); //Дата заезда
            $table->date('dep_date'); //Дата отъезда
            $table->string('email');
            $table->string('phone');
            $table->string('city');
            $table->foreignId('room_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_status_id')->constrained()->onDelete('cascade');

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
        Schema::dropIfExists('bookings');
    }
}
