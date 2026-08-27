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
        Schema::create('identitas_karya_ilmiahs', function (Blueprint $table) {
            $table->id();
            $table->string('tahun', 50)->nullable();
            $table->text('nama_jurnal')->nullable();
            $table->string('nomor_issn')->nullable();
            $table->string('volume')->nullable();
            $table->string('nomor')->nullable();
            $table->text('doi_artikel')->nullable();
            $table->text('alamat_web')->nullable();
            $table->string('kategori_publikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identitas_karya_ilmiahs');
    }
};
