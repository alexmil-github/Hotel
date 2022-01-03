<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('surname',100)->nullable();
            $table->string('patronymic',100)->nullable();
            $table->date('birthday')->nullable();
            $table->enum('gender',['м','ж'])->default('м');
            $table->foreignId('document_type_id')->constrained()->onDelete('cascade');
            $table->string('document_number',100)->unique();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('guests');
    }
}
