<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
 public function run()
{
    User::firstOrCreate(
        ['email' => 'admin@admin.com'], // evita duplicados
        [
            'name' => 'Admin',
            'password' => Hash::make('123456789'),
            'is_admin' => 1, // 👈 define como administrador
        ]
    );
}

}
