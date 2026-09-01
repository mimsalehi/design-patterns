<?php

declare(strict_types=1);

use App\Creational\AbstractFactory\ChaparLogisticsFactory;
use App\Creational\AbstractFactory\Legacy\OrderFulfillmentService;
use App\Creational\AbstractFactory\IranPostLogisticsFactory;
use App\Creational\AbstractFactory\OrderFulfillmentPipeline;
use App\Creational\AbstractFactory\TipaxLogisticsFactory;

$service = new OrderFulfillmentService();

echo "=== Processing Order #1001 via Iran Post ===\n";
$service->fulfill('iran_post', '1001', 2.5, 'Isfahan');

echo "=== Processing Order #1002 via Tipax Express ===\n";
$service->fulfill('tipax', '1002', 4.8, 'Shiraz');



// ============================================================================
// Scenario 1: Customer chooses National Iran Post (Standard Postal Service)
// ============================================================================
echo "=== Scenario 1: Order #1001 via Iran Post (Government Postal Service) ===\n";
$postPipeline = new OrderFulfillmentPipeline(new IranPostLogisticsFactory());
$postPipeline->fulfillOrder('1001', 2.50, 'Isfahan');

// ============================================================================
// Scenario 2: Customer chooses Tipax Express (Private Courier Service)
// ============================================================================
echo "=== Scenario 2: Order #1002 via Tipax Express (Priority Courier) ===\n";
$tipaxPipeline = new OrderFulfillmentPipeline(new TipaxLogisticsFactory());
$tipaxPipeline->fulfillOrder('1002', 4.80, 'Shiraz');

// ============================================================================
// Scenario 3: Customer chooses Chapar Post (Private Courier Service)
// ============================================================================
echo "=== Scenario 3: Order #1003 via Chapar Express (Priority Courier) ===\n";
$tipaxPipeline = new OrderFulfillmentPipeline(new ChaparLogisticsFactory());
$tipaxPipeline->fulfillOrder('1003', 14.80, 'Mashhad');