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
                'name' => 'Admin Sistem',
                'email' => 'admin@uis.ac.id',
                'password' => Hash::make('password'),
                'roles' => 'admin',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'homebase' => 'Teknik Informatika',
            ],
            [
                'name' => 'M. Ansar, SE,.MM',
                'email' => 'ansar@uis.ac.id',
                'password' => Hash::make('password'),
                'roles' => 'tatausaha',
                'fakultas' => 'FAKULTAS SAINS DAN TEKNOLOGI (FST)',
                'homebase' => null,
            ],
            [
                'name' => 'Perawaty Selfia Nasution, S.KL',
                'email' => 'perawati.selfia@uis.ac.id',
                'password' => Hash::make('password'),
                'roles' => 'tatausaha',
                'fakultas' => 'FAKULTAS ILMU KESEHATAN (FIKes)',
                'homebase' => null,
            ],
            [
                'name' => 'Rahman Syahputra, S. Sos., M. Si',
                'email' => 'rahman@uis.ac.id',
                'password' => Hash::make('password'),
                'roles' => 'tatausaha',
                'fakultas' => 'FAKULTAS EKONOMI DAN BISNIS (FEB)',
                'homebase' => null,
            ],
            [
                'name' => 'Dosen FST',
                'email' => 'dosen@uis.ac.id',
                'password' => Hash::make('password'),
                'roles' => 'dosen',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'homebase' => 'Teknik Informatika',
            ],
            [
                'name' => 'Dekan FST',
                'email' => 'dekan@uis.ac.id',
                'password' => Hash::make('password'),
                'roles' => 'dekan',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'homebase' => 'Teknik Informatika',
            ],
            [
                'name' => 'Wakil Dekan 1 FST',
                'email' => 'wd1@uis.ac.id',
                'password' => Hash::make('password'),
                'roles' => 'wakilDekan1',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'homebase' => 'Sistem Informasi',
            ],
            [
                'name' => 'Wakil Dekan 2 FST',
                'email' => 'wd2@uis.ac.id',
                'password' => Hash::make('password'),
                'roles' => 'wakilDekan2',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'homebase' => 'Teknik Industri',
            ],
            [
                'name' => 'Ketua Program Studi TI',
                'email' => 'kaprodi@uis.ac.id',
                'password' => Hash::make('password'),
                'roles' => 'kaprodi',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'homebase' => 'Teknik Informatika',
            ],
            [
                'name' => 'Sekretaris Program Studi TI',
                'email' => 'sekprodi@uis.ac.id',
                'password' => Hash::make('password'),
                'roles' => 'sekprodi',
                'fakultas' => 'Fakultas Sains dan Teknologi',
                'homebase' => 'Teknik Informatika',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
