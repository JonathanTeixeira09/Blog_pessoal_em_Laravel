<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'adm@adm.com',
            'password' => bcrypt('Admin@2023'),
            'thumbnail' => 'users/userAdmin.png',
            'is_admin' => '1',
        ]);
    }
}
