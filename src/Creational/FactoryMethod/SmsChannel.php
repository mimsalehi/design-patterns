<?php

namespace App\Creational\FactoryMethod;

use App\Creational\FactoryMethod\NotificationChannelInterface;

class SmsChannel implements NotificationChannelInterface
{
    public function __construct(private string $apiKey = "kavenegar_live_secret_key_9981")
    {
    }

    public function send(string $recipient, string $message): string
    {
        return sprintf(
            "[SMS Gateway] Dispatched to %s via Kavenagr (API Key: %s). Message: \"%s\"",
            $recipient,
            substr($this->apiKey, 0, 10) . '...',
            $message
        );
    }
}