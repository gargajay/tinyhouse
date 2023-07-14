<?php

namespace App\Providers;

use App\Models\Setting;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('settings')) {
            $isNameColumnExist = Schema::hasColumn('settings', 'name');

            if ($isNameColumnExist) {
                /******************************************************* SMTP *******************************************************/

                $smtpSetting = Setting::where('name', 'smtp')->first();

                if ($smtpSetting) {
                    $smtp = $smtpSetting->value;
                    config([
                        'mail.mailers.smtp.host' => $smtp['host'] ?? "smtp.gmail.com",
                        'mail.mailers.smtp.port' => $smtp['port'] ?? 587,
                        'mail.mailers.smtp.username' => $smtp['email'],
                        'mail.mailers.smtp.password' => $smtp['password'],
                        'mail.from.address' => $smtp['from_address'],
                        'mail.from.name' => $smtp['from_name'],
                    ]);
                }

                /******************************************************* STRIPE *******************************************************/

                $stripeSetting = Setting::where('name', 'stripe')->first();

                if ($stripeSetting) {
                    $stripe = $stripeSetting->value;
                    config([
                        'mail.stripe.secret_key' => $stripe['secret_key'],
                        'mail.stripe.public_key' => $stripe['public_key'],
                    ]);
                }

                /******************************************************* PUSH NOTIFICATION *******************************************************/

                $push_notification_server_key_setting = Setting::where('name', 'push_notification_server_key')->first();

                if ($push_notification_server_key_setting) {
                    $push_notification_server_key_setting = $push_notification_server_key_setting->value;
                    config([
                        'mail.push_notification.key' => $push_notification_server_key_setting['push_notification_server_key'] ?? NULL,
                    ]);
                }

                /******************************************************* DEBUG MODE *******************************************************/

                $debugModeSetting = Setting::where('name', 'debug_mode')->first();

                if ($debugModeSetting) {
                    $debugMode = $debugModeSetting->value;

                    config([
                        'app.debug' => $debugMode['debug_mode'],
                    ]);
                }
            }
        }
    }
}
