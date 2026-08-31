<?php

namespace App\Creational\FactoryMethod;

use App\Creational\FactoryMethod\NotificationChannelInterface;

class EmailChannel implements NotificationChannelInterface
{
    public function __construct(private string $smtpHost = 'smtp.mailtrap.io')
    {
    }

    public function send(string $recipient, string $message): string
    {
        return sprintf(
            "[Email Server] Dispatched to %s via SMTP (%s). Body: \"%s\"",
            $recipient,
            $this->smtpHost,
            $message
        );
    }
}