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
    }
}
