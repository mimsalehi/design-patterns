<?php

namespace App\Creational\AbstractFactory;

use App\Creational\AbstractFactory\LogisticsFactoryInterface;

class TipaxLogisticsFactory implements LogisticsFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function createRateCalculator(): ShippingRateCalculatorInterface
    {
        return new TipaxRateCalculator();
    }

    /**
     * @inheritDoc
     */
    public function createWaybillGenerator(): WaybillGeneratorInterface
    {
        return new TipaxWaybillGenerator();
    }

    /**
     * @inheritDoc
     */
    public function createPickupDispatcher(): PickupDispatcherInterface
    {
        return new TipaxPickupDispatcher();
    }
}