<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('akmalganteng'),
            'roles' => 'admin'
        ]);

        User::create([
            'name' => 'Finance',
            'email' => 'finance@gmail.com',
            'password' => Hash::make('financetamvan'),
            'roles' => 'finance'
        ]);
    }
}
