<?php

declare(strict_types=1);

use App\Creational\FactoryMethod\EmailNotificationService;
use App\Creational\FactoryMethod\NotificationService;
use App\Creational\FactoryMethod\NotificationTelegramService;
use App\Creational\FactoryMethod\SmsNotificationService;


function handelOrderConfirmation(NotificationService $notificationService, string $recipient, string $orderId, int $amount ): void{
    $result = $notificationService->send($recipient, $orderId, $amount);
    echo $result. "\n\n";
}

echo "=== Processing Order #1001 (Customer selected SMS) ===\n";
handelOrderConfirmation(new SmsNotificationService(), "+989111110202", "1001",  2500);


echo "=== Processing Order #1002 (Customer selected Email) ===\n";
handelOrderConfirmation(new EmailNotificationService(), "masoudsalehidev@gmail.com", "1002",  8800);

echo "=== Processing Order #1003 (Customer selected Telegram) ===\n";
handelOrderConfirmation(new NotificationTelegramService(), "masood_salehi_x", "1003",  12800);