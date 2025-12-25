<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'tata usaha',
                'email' => 'tu.ft@uis.ac.id',
                'password' => Hash::make('password'),
                'isAdmin' => true,
                'isDosen' => false,
                'isKaProdi' => false,
                'isSekProdi' => false,
                'isDekan' => false,
                'isWakilDekan1' => false,
                'isWakilDekan2' => false,
            ],
            [
                'name' => 'dosen',
                'email' => 'dosen@uis.ac.id',
                'password' => Hash::make('password'),
                'isAdmin' => false,
                'isDosen' => true,
                'isKaProdi' => false,
                'isSekProdi' => false,
                'isDekan' => false,
                'isWakilDekan1' => false,
                'isWakilDekan2' => false,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
