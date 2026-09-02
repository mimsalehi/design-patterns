<?php

declare(strict_types=1);

use App\Creational\FactoryMethod\EmailNotificationService;
use App\Creational\FactoryMethod\Legacy\OrderNotificationService as LegacyNotificationService;
use App\Creational\FactoryMethod\NotificationService;
use App\Creational\FactoryMethod\NotificationTelegramService;
use App\Creational\FactoryMethod\SmsNotificationService;

// ============================================================================
// 0. Legacy approach comparison (Monolithic with if/else conditionals)
// ============================================================================
echo "=== 0. Legacy Monolithic Notification Service ===\n";
$legacyService = new LegacyNotificationService();
$legacyService->send('sms', '+989111110202', '1001', 2500.00);
$legacyService->send('email', 'masoudsalehidev@gmail.com', '1002', 8800.00);
$legacyService->send('telegram', 'masood_salehi_x', '1003', 12800.00);

// ============================================================================
// 1. Refactored Factory Method approach (Polymorphic & Decoupled)
// ============================================================================
echo "=== 1. Factory Method Pattern Implementation ===\n";
function handleOrderConfirmation(NotificationService $notificationService, string $recipient, string $orderId, float $amount): void
{
    $result = $notificationService->send($recipient, $orderId, $amount);
    echo $result . "\n\n";
}

echo "=== Processing Order #1001 (Customer selected SMS) ===\n";
handleOrderConfirmation(new SmsNotificationService(), "+989111110202", "1001", 2500.00);

echo "=== Processing Order #1002 (Customer selected Email) ===\n";
handleOrderConfirmation(new EmailNotificationService(), "masoudsalehidev@gmail.com", "1002", 8800.00);

echo "=== Processing Order #1003 (Customer selected Telegram) ===\n";
handleOrderConfirmation(new NotificationTelegramService(), "masood_salehi_x", "1003", 12800.00);
