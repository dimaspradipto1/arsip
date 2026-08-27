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
        Schema::table('identitas_karya_ilmiahs', function (Blueprint $table) {
            if (!Schema::hasColumn('identitas_karya_ilmiahs', 'judul_karya_ilmiah')) {
                $table->text('judul_karya_ilmiah')->nullable()->after('tahun');
            }
            if (!Schema::hasColumn('identitas_karya_ilmiahs', 'volume_nomor_tahun')) {
                $table->string('volume_nomor_tahun')->nullable()->after('nomor_issn');
            }
            if (!Schema::hasColumn('identitas_karya_ilmiahs', 'indexing')) {
                $table->string('indexing')->nullable()->after('alamat_web');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identitas_karya_ilmiahs', function (Blueprint $table) {
            if (Schema::hasColumn('identitas_karya_ilmiahs', 'judul_karya_ilmiah')) {
                $table->dropColumn('judul_karya_ilmiah');
            }
            if (Schema::hasColumn('identitas_karya_ilmiahs', 'volume_nomor_tahun')) {
                $table->dropColumn('volume_nomor_tahun');
            }
            if (Schema::hasColumn('identitas_karya_ilmiahs', 'indexing')) {
                $table->dropColumn('indexing');
            }
        });
    }
};
