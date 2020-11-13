<?php

namespace Va\SmartSms\Channels;

use Illuminate\Notifications\Notification;
use Va\SmartSms\Facades\SmartSmsServiceFacade;

class SmartSmsChannel
{
    public $mobile_field;

    public function __construct()
    {
        $this->mobile_field = config('smart-sms.mobile_field_name');
    }

    public function send($notifiable, Notification $notification)
    {
        if(! method_exists($notification, 'toChannel')) {
            throw new \Exception('toSls method not found.');
        }
        $data = $notification->toChannel();
        $message = $data['text'];
        if(!empty($data['group'])) {
            $receptor = $data['group'];
        } else {
            $receptor = ($data['mobile'] == null) ? $notifiable->{$this->mobile_field} : $data['mobile'];
        }
        SmartSmsServiceFacade::send($receptor, $message);
    }
}
