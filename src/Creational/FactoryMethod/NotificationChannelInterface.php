<?php

namespace App\Creational\FactoryMethod;

interface NotificationChannelInterface
{
    public function send(string $recipient, string $message): string;
}