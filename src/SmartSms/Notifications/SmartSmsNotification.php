<?php

namespace Va\SmartSms\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Va\SmartSms\Channels\SmartSmsChannel;

class SmartSmsNotification extends Notification
{
    use Queueable;

    public $message;
    public $mobile;
    public $group;

    /**
     * ActiveCodeNotification constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SmartSmsChannel::class];
    }

    public function toSls()
    {
        return [
            'text' => $this->message,
            'mobile' => $this->mobile,
            'group' => $this->group
        ];
    }

    /**
     * @param string $message
     * @return $this
     */
    public function message(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param string|null $mobile
     * @return $this
     */
    public function mobile(string $mobile = null)
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @param array $group
     * @return $this
     */
    public function group(array $group = [])
    {
        $this->group = $group;
        return $this;
    }
}
