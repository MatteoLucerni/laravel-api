<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'Matteo';
        $user->email = 'matteo@boolean.it';
        $user->password = bcrypt('cicciopazzo');
        $user->save();
    }
}
