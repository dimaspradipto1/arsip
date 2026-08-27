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
        Schema::create('kartu_rencana_studis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahunakademik_id')->constrained('tahun_akademiks')->cascadeOnDelete();
            $table->foreignId('ketua_panitia_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('sekretaris_id')->constrained('users')->cascadeOnDelete();
            $table->text('dokumen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartu_rencana_studis');
    }
};
