# Laravel Sms Notification
[![GitHub issues](https://img.shields.io/github/issues/va1hi9da9sh2ou0rz2ad1eh7/smart-sms?style=flat-square)](https://github.com/va1hi9da9sh2ou0rz2ad1eh7/cutlet-helper/issues)
[![GitHub stars](https://img.shields.io/github/stars/va1hi9da9sh2ou0rz2ad1eh7/smart-sms?style=flat-square)](https://github.com/va1hi9da9sh2ou0rz2ad1eh7/cutlet-helper/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/va1hi9da9sh2ou0rz2ad1eh7/smart-sms?style=flat-square)](https://github.com/va1hi9da9sh2ou0rz2ad1eh7/cutlet-helper/network)
[![GitHub license](https://img.shields.io/github/license/va1hi9da9sh2ou0rz2ad1eh7/smart-sms?style=flat-square)](https://github.com/va1hi9da9sh2ou0rz2ad1eh7/cutlet-helper/blob/master/LICENSE)

Sms Notification service and channel for send sms with [smartsms.ir](https://smartsms.ir/)

##How to install and config [va/smart-sms](https://github.com/va1hi9da9sh2ou0rz2ad1eh7/smart-sms) package?

#### Installation

```

composer require va/smart-sms

```

#### Publish Config file

```

php artisan vendor:publish --tag=smart-sms

```

#### Where is the config file? In config/smart-sms.php

```

'line_number' => env('SMS_LINE_NUMBER'),
'user_id' => env('SMS_USER_ID'),
'password' => env('SMS_PASSWORD'),
'default_sms_rcpt' => env('SMS_DEFAULT_SMS_RCPT'),
'mobile_field_name' => env('SMS_MOBILE_FIELD_NAME', 'mobile')

```

#### Set You're private configs in .env file, for example

```

SMS_LINE_NUMBER=10001010
SMS_USER_ID=12345
SMS_PASSWORD=123456789
SMS_DEFAULT_SMS_RCPT=0901***1020 // You're phone number for test on local mode or (.env => APP_ENV=local)
SMS_MOBILE_FIELD_NAME=mobile // Name of the mobile field in you're User model or users migration or users table

```

## How to use [va/smart-sms](https://github.com/va1hi9da9sh2ou0rz2ad1eh7/smart-sms) package?

#### Default Facade for send message and it's methods

```

// The default message:

$message = 'You're message;

// If we want to send a message to $user:

$user->notify(SmsNotificationFacade::message($message)); // mobile = $user->mobile, message = $message
or
$request->user->notify(SmsNotificationFacade::message($message)); // mobile = $user->mobile, message = $message

// If we want to send a mesage to another mobile number:

$user->notify(SmsNotificationFacade::message($message)->mobile('0901***1020')); // mobile = 0901***1020, message = $message

// If we want to send a message to another mobile numbers (Send Group message):

$user->notify(SmsNotificationFacade::message($message)->group(['0901***1020', '0901***3040']));

```

#### Create a custom sms notification and use this

- Make a new notification

    ```
    php artisan make:sms-notification SendActivationNotification
    ```
- In which directory was this class made?

    ```
    app/Notifications/Message/SendActivationNotification.php
    ```
- Content of this Notification
 
     ```
     <?php
 
     namespace App\Notifications\Message;
 
     use Illuminate\Bus\Queueable;
     use Illuminate\Notifications\Notification;
     use Va\SmartSms\Channels\SmartSmsChannel;
 
     class SendActivationNotification extends Notification
     {
         use Queueable;
 
         public $message;
         public $mobile;
         public $group;
 
         /**
          * SendActivationNotification constructor.
          * @param string|null $message
          * @param string|null $mobile
          * @param array $group
          */
         public function __construct(string $message = null, string $mobile = null, array $group = [])
         {
             $this->message = $message;
             $this->mobile = $mobile;
             $this->group = $group;
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
 
         public function toChannel()
         {
             return [
                 'text' => "You're message" OR $this->message, // You're default (text of message)
                 'mobile' => $this->mobile,
                 'group' => $this->group
             ];
         }
     }
 
     ```
  
- Use this Notification for send message

    ```
    // If we want to send a message with this notification

    $user->notify(new SendActivationNotification()); // mobile = $user->mobile, message = (Default meassge in notification)

    // If we want to send a message to another mobile number:

    $user->notify(new SendActivationNotification(null, '0901***1020')); // mobile = $user->mobile, message = (Default meassge in notification)

    // If we want to send a message to another mobile numbers (Send Group message):

    $user->notify(new SendActivationNotification(null, null, ['0901***1020', '0901***3040'])); // mobile = array, message = (Default meassge in notification)

    // If we want to push a message to notification class

    $message = "You're message";
    $user->notify(new SendActivationNotification($message)); // mobile = $user->mobile, message = $message
    ```


