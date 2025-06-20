<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuário administrador padrão
        User::create([
            'name' => 'Admin Sistema',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Vendedor 1
        User::create([
            'name' => 'João Vendedor',
            'email' => 'joao@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Vendedor 2
        User::create([
            'name' => 'Maria Silva',
            'email' => 'maria@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Vendedor 3
        User::create([
            'name' => 'Carlos Santos',
            'email' => 'carlos@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Gerente
        User::create([
            'name' => 'Ana Gerente',
            'email' => 'ana@test.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}