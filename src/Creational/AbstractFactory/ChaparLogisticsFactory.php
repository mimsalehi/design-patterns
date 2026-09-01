<?php

namespace App\Creational\AbstractFactory;

use App\Creational\AbstractFactory\LogisticsFactoryInterface;

class ChaparLogisticsFactory implements LogisticsFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function createRateCalculator(): ShippingRateCalculatorInterface
    {
        return new ChaparPostRateCalculator();
    }

    /**
     * @inheritDoc
     */
    public function createWaybillGenerator(): WaybillGeneratorInterface
    {
        return new ChaparPostWaybillGenerator();
    }

    /**
     * @inheritDoc
     */
    public function createPickupDispatcher(): PickupDispatcherInterface
    {
        return new ChaparPostPickupDispatcher();
    }
}