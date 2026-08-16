<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SchoolClass::create(['name' => 'X RPL 2']);
        SchoolClass::create(['name' => 'XI RPL 2']);
        SchoolClass::create(['name' => 'XII RPL 2']);
    }
}
