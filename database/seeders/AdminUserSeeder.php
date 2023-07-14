<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VaultReciever;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'Gocarhub',
            'first_name' => 'Gocarhub',
            'last_name' => 'App',
            'name' =>'Gocarhub App',
            'email' => strtolower('GOCARHUBAPP@gmail.com'),
            'password' => bcrypt('+VPgzbvW*cm6pG@q'),
            'user_type' => 'admin',
            'country_code' => '+91',
            'mobile' => '9988776655'
        ]);

        User::create([
            'username' => 'office3',
            'first_name' => 'office',
            'last_name' => '3',
            'name' =>'office3 cepoch',
            'email' => strtolower('office3.cepoch@gmail.com'),
            'password' => bcrypt('MkK4xHv8N5GNad8Q'),
            'user_type' => 'admin',
            'country_code' => '+91',
            'mobile' => '9988776655'
        ]);
    }
}
