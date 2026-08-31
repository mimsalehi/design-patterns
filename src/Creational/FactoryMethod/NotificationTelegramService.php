<?php

namespace App\Creational\FactoryMethod;

use App\Creational\FactoryMethod\NotificationService;

class NotificationTelegramService extends NotificationService
{

    public function createChannel(): NotificationChannelInterface
    {
        return new TelegramChannel();
    }
}