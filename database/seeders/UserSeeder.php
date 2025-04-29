<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        if (count(User::get()) == 0) {
            User::create([
                'name' => 'Olimpus',
                'email' => 'admin@olimpus.com',
                'password' => Hash::make('123456'),
                
                'perfil_id' => 1, // Associado ao Grupo A
                'status' => 1,
            ]);
        }
        
    }
}
