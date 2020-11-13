<?php

namespace Va\SmartSms;

use App\Console\Commands\SmartSmsCommand;
use Illuminate\Support\ServiceProvider;
use Va\SmartSms\Facades\SmartSmsServiceFacade;
use Va\SmartSms\Facades\SmsNotificationFacade;
use Va\SmartSms\Notifications\SmartSmsNotification;
use Va\SmartSms\Services\SmartSms;

class SmartSmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        SmartSmsServiceFacade::shouldProxyTo(SmartSms::class);
        SmsNotificationFacade::shouldProxyTo(SmartSmsNotification::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            SmartSmsCommand::class
        ]);

        $this->publishes([
            __DIR__ . '/../config/smart-sms.php' => config_path('smart-sms.php'),
        ], 'smart-sms');
    }
}
