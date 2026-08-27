<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('roles')->change();
        });

        // Convert existing single role strings to JSON format
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            if ($user->roles) {
                // If it's already valid JSON array, keep it
                $decoded = json_decode($user->roles, true);
                if (!is_array($decoded)) {
                    $rolesArray = array_values(array_filter(array_map('trim', explode(',', $user->roles))));
                    DB::table('users')->where('id', $user->id)->update([
                        'roles' => json_encode($rolesArray)
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to varchar/text or default
        Schema::table('users', function (Blueprint $table) {
            $table->string('roles', 255)->default('dosen')->change();
        });
    }
};
