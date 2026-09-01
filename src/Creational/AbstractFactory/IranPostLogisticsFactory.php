<?php

namespace App\Creational\AbstractFactory;

use App\Creational\AbstractFactory\LogisticsFactoryInterface;

class IranPostLogisticsFactory implements LogisticsFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function createRateCalculator(): ShippingRateCalculatorInterface
    {
        return new IranPostRateCalculator();
    }

    /**
     * @inheritDoc
     */
    public function createWaybillGenerator(): WaybillGeneratorInterface
    {
        return new IranPostWaybillGenerator();
    }

    /**
     * @inheritDoc
     */
    public function createPickupDispatcher(): PickupDispatcherInterface
    {
        return new IranPostPickupDispatcher();
    }
}