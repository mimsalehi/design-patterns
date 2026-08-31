<?php

namespace App\Creational\FactoryMethod;

use App\Creational\FactoryMethod\NotificationService;

class EmailNotificationService extends NotificationService
{

    public function createChannel(): NotificationChannelInterface
    {
        return new EmailChannel();
    }
}