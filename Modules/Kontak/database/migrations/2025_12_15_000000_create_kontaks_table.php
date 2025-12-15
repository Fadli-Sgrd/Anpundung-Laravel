<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kontaks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kontaks');
    }
};
