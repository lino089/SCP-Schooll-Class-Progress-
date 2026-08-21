<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Pak WAKA',
            'username' => 'waka_kurikulum',
            'email'=> 'waka@skansaba.sch.id',
            'role_id' => 1,
            'password' => Hash::make('admin123')
        ]);

        User::create([
            'name' => 'siswa aja',
            'username' => 'siswa01',
            'email' => 'siswa@skansaba.sch.id',
            'role_id' => 2,
            'class_id' => 1,
            'password' => Hash::make('siswa123')
        ]);

        User::create([
            'name' => 'guru1',
            'username' => 'guru01',
            'email' => 'guru@skansaba.sch.id',
            'role_id' => 3,
            'password' => Hash::make('guru123')
        ]);

        User::create([
            'name' => 'kesiswaan1',
            'username' => 'kesiswaan01',
            'email' => 'kesiswaan@skansaba.sch.id',
            'role_id' => 4,
            'password' => Hash::make('kesiswaan123')
        ]);
    }
}
