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
        // 1. Drop column sekretaris_id from main tables
        $tables = [
            'beban_kerja_dosens',
            'semester_antaras',
            'kuliah_pengabdian_masyarakats',
            'kartu_rencana_studis',
            'ujian_tengah_semesters',
            'ujian_akhir_semesters',
            'yudisia',
            'wisudas',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $tableBlueprint) {
                if (Schema::hasColumn($tableBlueprint->getTable(), 'sekretaris_id')) {
                    $tableBlueprint->dropForeign([ 'sekretaris_id' ]);
                    $tableBlueprint->dropColumn('sekretaris_id');
                }
            });
        }

        // 2. Create pivot tables for each module
        Schema::create('beban_kerja_dosen_sekretaris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beban_kerja_dosen_id')->constrained('beban_kerja_dosens')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('semester_antara_sekretaris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_antara_id')->constrained('semester_antaras')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('kuliah_pengabdian_masyarakat_sekretaris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kuliah_pengabdian_masyarakat_id')->constrained('kuliah_pengabdian_masyarakats', 'id', 'kpm_sekretaris_kpm_id_foreign')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('kartu_rencana_studi_sekretaris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kartu_rencana_studi_id')->constrained('kartu_rencana_studis', 'id', 'krs_sekretaris_krs_id_foreign')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('ujian_tengah_semester_sekretaris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ujian_tengah_semester_id')->constrained('ujian_tengah_semesters', 'id', 'uts_sekretaris_uts_id_foreign')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('ujian_akhir_semester_sekretaris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ujian_akhir_semester_id')->constrained('ujian_akhir_semesters', 'id', 'uas_sekretaris_uas_id_foreign')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('yudisium_sekretaris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('yudisium_id')->constrained('yudisia')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('wisuda_sekretaris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wisuda_id')->constrained('wisudas')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisuda_sekretaris');
        Schema::dropIfExists('yudisium_sekretaris');
        Schema::dropIfExists('ujian_akhir_semester_sekretaris');
        Schema::dropIfExists('ujian_tengah_semester_sekretaris');
        Schema::dropIfExists('kartu_rencana_studi_sekretaris');
        Schema::dropIfExists('kuliah_pengabdian_masyarakat_sekretaris');
        Schema::dropIfExists('semester_antara_sekretaris');
        Schema::dropIfExists('beban_kerja_dosen_sekretaris');

        $tables = [
            'beban_kerja_dosens',
            'semester_antaras',
            'kuliah_pengabdian_masyarakats',
            'kartu_rencana_studis',
            'ujian_tengah_semesters',
            'ujian_akhir_semesters',
            'yudisia',
            'wisudas',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $tableBlueprint) {
                $tableBlueprint->foreignId('sekretaris_id')->nullable()->constrained('users')->cascadeOnDelete();
            });
        }
    }
};
