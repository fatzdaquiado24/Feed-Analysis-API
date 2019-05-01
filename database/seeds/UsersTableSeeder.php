<?php

use Illuminate\Database\Seeder;

use App\HeadManager;
use App\Client;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HeadManager::truncate();
        HeadManager::create([
            'name' => 'Charles Salinas',
            'email' => 'admin@test.com',
            'password' => Hash::make('password')
        ]);
    }
}
