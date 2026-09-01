<?php

namespace App\Creational\AbstractFactory;

interface LogisticsFactoryInterface
{
    /**
     * Creates a compatible rate calculator for this logistics family.
     */
    public function createRateCalculator(): ShippingRateCalculatorInterface;

    /**
     * Creates a compatible waybill and label generator for this logistics family.
     */
    public function createWaybillGenerator(): WaybillGeneratorInterface;

    /**
     * Creates a compatible courier/collector pickup dispatcher for this logistics family.
     */
    public function createPickupDispatcher(): PickupDispatcherInterface;

}