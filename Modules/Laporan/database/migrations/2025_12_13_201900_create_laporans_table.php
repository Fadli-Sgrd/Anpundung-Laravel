<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /** * Run the migrations. */ public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('kode_laporan');
            $table->string('judul');
            $table->date('tanggal');
            $table->string('alamat');
            // foreign key/relation
            $table->foreignId('id_kategori')->constrained(
                table: 'kategori_laporan',
                indexName: 'laporan_id_kategori'
            );
            $table->foreignId('user_id')->constrained(
                table: 'users',
                indexName: 'laporan_user_id'
            );
            $table->text('deskripsi');
            $table->enum('status_tindakan', ['Pending', 'Proses', 'Selesai', 'Ditolak'])->default('Pending');
            $table->timestamps();
            // $table->unsignedBigInteger('id_kategori');
            // $table->unsignedBigInteger('user_id');
            // $table->foreign('id_kategori')->references('id')->on('kategori_laporan')->onDelete('restrict');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    /** * Reverse the migrations. */ public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
