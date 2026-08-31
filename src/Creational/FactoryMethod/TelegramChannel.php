<?php

namespace App\Creational\FactoryMethod;

use App\Creational\FactoryMethod\NotificationChannelInterface;

class TelegramChannel implements NotificationChannelInterface
{
    public function __construct(private string $telegramApiKey = "telegram_12309_key")
    {
    }

    public function send(string $recipient, string $message): string
    {
        return sprintf(
            "[Telegram Gateway] Dispatched to %s via Telegram (API Key: %s). Message: \"%s\"",
            $recipient,
            substr($this->telegramApiKey, 0, 10) . '...',
            $message
        );
    }
}