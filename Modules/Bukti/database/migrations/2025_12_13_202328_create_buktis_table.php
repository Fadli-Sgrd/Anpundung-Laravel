<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bukti', function (Blueprint $table) {
            $table->id('kode_bukti');
            $table->unsignedBigInteger('kode_laporan');

            $table->enum('jenis', ['Gambar', 'Video']);
            $table->string('path_file');
            $table->text('deskripsi')->nullable();

            $table->timestamps();

            $table->foreign('kode_laporan')
                ->references('kode_laporan')
                ->on('laporan')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti');
    }
};
