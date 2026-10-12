<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Credenciais ficam no .env (ADMIN_EMAIL / ADMIN_PASSWORD), nunca no código
        if (!env('ADMIN_EMAIL') || !env('ADMIN_PASSWORD')) {
            throw new \RuntimeException('Defina ADMIN_EMAIL e ADMIN_PASSWORD no .env antes de rodar o seeder.');
        }

        User::create([
            'name' => 'Admin',
            'email' => env('ADMIN_EMAIL'),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'is_admin' => 1,
        ]);
    }
}