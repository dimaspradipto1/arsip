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
        Schema::create('sk_pembimbing_akademiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahunakademik_id')->constrained('tahun_akademiks')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nomor_sk');
            $table->string('fakultas')->nullable();
            $table->string('prodi')->nullable();
            $table->string('dokumen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_pembimbing_akademiks');
    }
};
