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
        Schema::create('sk_pembimbing_kpms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahunakademik_id')->constrained('tahun_akademiks')->cascadeOnDelete();
            $table->string('nomor_sk');
            $table->string('prodi')->nullable();
            $table->string('dokumen');
            $table->timestamps();
        });

        Schema::create('sk_pembimbing_kpm_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sk_pembimbing_kpm_id')->constrained('sk_pembimbing_kpms')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_pembimbing_kpm_user');
        Schema::dropIfExists('sk_pembimbing_kpms');
    }
};
