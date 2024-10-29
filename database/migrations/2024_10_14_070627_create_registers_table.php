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
        // membuat tabel pendaftaran magang
        Schema::create('internships', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('no_telp');
            $table->string('no_induk');
            $table->string('asal_institusi');
            $table->string('jurusan');
            $table->string('bidang_diambil');
            $table->string('surat_pengantar');
            $table->date('tanggal_awal_magang');
            $table->date('tanggal_akhir_magang');
            $table->string('approve_magang')->default('diproses');
            $table->string('nilai_magang')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registers');
    }
};
