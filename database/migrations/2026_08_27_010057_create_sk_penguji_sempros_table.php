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
        Schema::create('sk_penguji_sempros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahunakademik_id')->constrained('tahun_akademiks')->cascadeOnDelete();
            $table->string('nomor_sk');
            $table->string('nama_mahasiswa');
            $table->string('npm');
            $table->date('tanggal_sk');
            $table->string('dokumen');
            $table->timestamps();
        });

        Schema::create('sk_penguji_sempro_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sk_penguji_sempro_id')->constrained('sk_penguji_sempros')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_penguji_sempro_user');
        Schema::dropIfExists('sk_penguji_sempros');
    }
};

