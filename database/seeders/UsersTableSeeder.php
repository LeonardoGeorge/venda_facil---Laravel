<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Limpar a tabela primeiro
        DB::table('users')->delete();

        // Criar usuário admin
        DB::table('users')->insert([
            'name' => 'Leonardo',
            'email' => 'leonardo@vendas.com',
            'password' => Hash::make('250101'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        echo "✅ Usuário Leonardo criado com senha: 250101\n";
    }
}
