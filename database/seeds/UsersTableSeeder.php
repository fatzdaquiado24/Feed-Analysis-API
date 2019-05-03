<?php

use Illuminate\Database\Seeder;

use App\HeadManager;
use App\Chemist;
use App\Receiver;
use App\CertificateReleaser;
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
            'name' => 'Kristean Jean C. Laput',
            'email' => 'admin@test.com',
            'password' => Hash::make('password')
        ]);

        Chemist::truncate();
        Chemist::create([
            'name' => 'Example Chemist',
            'email' => 'chemist@example.com',
            'password' => Hash::make('password')
        ]);

        Receiver::truncate();
        Receiver::create([
            'name' => 'Example Receiver',
            'email' => 'receiver@example.com',
            'password' => Hash::make('password')
        ]);

        CertificateReleaser::truncate();
        CertificateReleaser::create([
            'name' => 'Example Releaser',
            'email' => 'certificate-releaser@example.com',
            'password' => Hash::make('password')
        ]);
    }
}
