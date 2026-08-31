<?php 

declare(strict_types=1);

namespace App\Creational\FactoryMethod\Legacy;

use InvalidArgumentException;


/**
 * Monolithic notification service handling business logic,
 * channel selection, vendor setup, and message dispatching.
 */
class OrderNotificationService
{
    public function send(string $channel, string $recipient, string $orderId, float $totalAmount): void
    {
        // 1. Common business logic: Message formatting
        $message = sprintf(
            "Your order #%s with total amount of $%0.2f has been confirmed.",
            $orderId,
            $totalAmount
        );

        // 2. Tightly-coupled vendor dispatching logic
        if ($channel === 'sms') {
            // SMS Gateway connection
            $apiKey = "kavenegar_live_secret_key_9981";
            
            echo "[SMS Dispatcher]\n";
            echo "  Recipient: {$recipient}\n";
            echo "  Message: \"{$message}\"\n";
            echo "  Status: Delivered successfully (Cost: $0.02)\n\n";

        } elseif ($channel === 'email') {
            // Email SMTP connection
            $smtpHost = "smtp.sendgrid.net";

            echo "[Email Dispatcher]\n";
            echo "  Recipient: {$recipient}\n";
            echo "  Subject: Order Confirmation #{$orderId}\n";
            echo "  Body: \"{$message}\"\n";
            echo "  Status: Delivered successfully (Cost: $0.00)\n\n";
        } elseif ($channel === 'telegram') {
            $telegramApiKey = "telegram_api_key_9981";
            echo "[Telegram Dispatcher]\n";
            echo "  Recipient: {$recipient}\n";
            echo "  Message: \"{$message}\"\n";
            echo "  Status: Delivered successfully (Cost: $0.02)\n\n";

        } else {
            throw new InvalidArgumentException("Unsupported notification channel: [{$channel}]");
        }
    }
}
