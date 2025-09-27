<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardersTable extends Migration
{
    public function up()
    {
        Schema::create('boarders', function (Blueprint $table) {
            $table->id();
            $table->string('boarder_id')->unique(); // e.g., generated alphanumeric or QR token
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('course')->nullable();
            $table->string('year_level')->nullable();
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->date('move_in_date')->nullable();
            $table->date('move_out_date')->nullable();
            $table->json('emergency_contacts')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('boarders');
    }
}

