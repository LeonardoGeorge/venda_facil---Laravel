<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Leonardo',
                'email' => 'leonardo@vendafacil.com',
                'email_verified_at' => now(),
                'password' => Hash::make('250101'), // Senha criptografada
                'remember_token' => Str::random(10),
                'phone' => '(19) 99999-9999',
                'created_at' => now(),
                'updated_at' => now(),
            ]
            
        ];

        DB::table('users')->insert($users);
    }
}
