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
        Schema::create('laporan_penelitians', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_kegiatan', 50);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('judul_penelitian');
            $table->text('dokumen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_penelitians');
    }
};
