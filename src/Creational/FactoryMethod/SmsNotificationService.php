<?php

namespace App\Creational\FactoryMethod;

use App\Creational\FactoryMethod\NotificationService;

class SmsNotificationService extends NotificationService
{

    public function createChannel(): NotificationChannelInterface
    {
        return new SmsChannel();
    }
}