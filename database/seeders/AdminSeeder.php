<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminEmail = SUPER_ADMIN_EMAIL ?? 'admin@admin.com';
        $adminUserName = SUPER_ADMIN_USERNAME ?? 'admin';
        $adminFirstName = SUPER_ADMIN_FIRST_NAME ?? 'Admin';
        $adminLastName = SUPER_ADMIN_LAST_NAME ?? 'User';
        $adminObj = User::where('user_type', 'admin')->first();

        if (!$adminObj) {
            User::create([
                'username' => SUPER_ADMIN_USERNAME,
                'first_name' => SUPER_ADMIN_FIRST_NAME,
                'last_name' => SUPER_ADMIN_LAST_NAME,
                'name' => SUPER_ADMIN_FIRST_NAME . ' ' . SUPER_ADMIN_LAST_NAME,
                'email' => SUPER_ADMIN_EMAIL,
                'password' => bcrypt('123456'),
                'user_type' => 'admin',
                'country_code' => '+91',
                'mobile' => '9988776655'
            ]);
            User::create([
                'username' => ADMIN_USERNAME,
                'first_name' => ADMIN_FIRST_NAME,
                'last_name' => ADMIN_LAST_NAME,
                'name' => ADMIN_FIRST_NAME . ' ' . ADMIN_LAST_NAME,
                'email' => ADMIN_EMAIL,
                'password' => bcrypt('123456'),
                'user_type' => 'admin',
                'country_code' => '+91',
                'mobile' => '9988776655'
            ]);
            User::create([
                'username' => DEVELOPER_USERNAME,
                'first_name' => DEVELOPER_FIRST_NAME,
                'last_name' => DEVELOPER_LAST_NAME,
                'name' => DEVELOPER_FIRST_NAME . ' ' . DEVELOPER_LAST_NAME,
                'email' => DEVELOPER_EMAIL,
                'password' => bcrypt('123456'),
                'user_type' => 'admin',
                'country_code' => '+91',
                'mobile' => '9988776655'
            ]);
        }

        $smtp = [
            'email' => 'cepochdevelopers@gmail.com',
            'password' => 'hmnnjrhhnzklcyae',
            'host' => 'smtp.gmail.com',
            'port' => '587',
            'from_address' => 'cepochdevelopers@gmail.com',
            'from_name' => APP_NAME,
        ];

        $jsonData = json_encode($smtp);

        $settingObj = Setting::where('name', 'smtp')->first();

        if (!$settingObj) {
            $settingObj = new Setting;
            $settingObj->name = 'smtp';
            $settingObj->description = 'SMTP setting is using to setup the mail configuration';
        }
        $settingObj->value = $jsonData;
        $settingObj->save();
    }
}
