<?php

namespace App\Creational\AbstractFactory;

class OrderFulfillmentPipeline
{
    private ShippingRateCalculatorInterface $rateCalculator;
    private WaybillGeneratorInterface $waybillGenerator;
    private PickupDispatcherInterface $pickupDispatcher;

    public function __construct(LogisticsFactoryInterface $factory)
    {
        // 1. Obtain full consistent product family from the injected factory
        $this->rateCalculator = $factory->createRateCalculator();
        $this->waybillGenerator = $factory->createWaybillGenerator();
        $this->pickupDispatcher = $factory->createPickupDispatcher();
    }

    public function fulfillOrder(string $orderId, float $weightInKg, string $destinationCity): array
    {
        echo sprintf("--- Starting Fulfillment Workflow for Order #%s ---\n", $orderId);

        // Step 1: Calculate shipping rate
        $cost = $this->rateCalculator->calculate($orderId, $weightInKg, $destinationCity);

        // Step 2: Generate tracking waybill barcode and label
        $waybill = $this->waybillGenerator->generate($orderId);

        // Step 3: Dispatch pickup collection
        $dispatchId = $this->pickupDispatcher->dispatch($orderId);

        echo "--- Order Dispatched Successfully ---\n\n";

        return [
            'order_id' => $orderId,
            'cost_irr' => $cost,
            'waybill' => $waybill,
            'dispatch_id' => $dispatchId,
        ];
    }

}