<?php

namespace App\Creational\FactoryMethod;

abstract class NotificationService
{
    abstract public function createChannel(): NotificationChannelInterface;

    public function send(string $recipient, string $orderId, float $totalAmount): string
    {
        // 1. Format order message
        $message = sprintf(
            "Your order #%s with total amount of $%0.2f has been confirmed.",
            $orderId,
            $totalAmount
        );

        // 2. Call the factory method to obtain the channel product
        $channel = $this->createChannel();

        // 3. Dispatch the message
        return $channel->send($recipient, $message);
    }
}