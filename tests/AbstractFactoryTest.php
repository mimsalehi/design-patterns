<?php

use App\Creational\AbstractFactory\IranPostLogisticsFactory;
use App\Creational\AbstractFactory\IranPostPickupDispatcher;
use App\Creational\AbstractFactory\IranPostRateCalculator;
use App\Creational\AbstractFactory\IranPostWaybillGenerator;
use App\Creational\AbstractFactory\LogisticsFactoryInterface;
use App\Creational\AbstractFactory\OrderFulfillmentPipeline;
use App\Creational\AbstractFactory\PickupDispatcherInterface;
use App\Creational\AbstractFactory\ShippingRateCalculatorInterface;
use App\Creational\AbstractFactory\TipaxLogisticsFactory;
use App\Creational\AbstractFactory\TipaxPickupDispatcher;
use App\Creational\AbstractFactory\TipaxRateCalculator;
use App\Creational\AbstractFactory\TipaxWaybillGenerator;
use App\Creational\AbstractFactory\WaybillGeneratorInterface;
use PHPUnit\Framework\TestCase;

class AbstractFactoryTest extends TestCase
{

    public function testIranPostFactoryCreatesConsistentProductFamily(): void
    {
        $factory = new IranPostLogisticsFactory();

        $rateCalculator = $factory->createRateCalculator();
        $waybillGenerator = $factory->createWaybillGenerator();
        $pickupDispatcher = $factory->createPickupDispatcher();

        $this->assertInstanceOf(ShippingRateCalculatorInterface::class, $rateCalculator);
        $this->assertInstanceOf(IranPostRateCalculator::class, $rateCalculator);

        $this->assertInstanceOf(WaybillGeneratorInterface::class, $waybillGenerator);
        $this->assertInstanceOf(IranPostWaybillGenerator::class, $waybillGenerator);

        $this->assertInstanceOf(PickupDispatcherInterface::class, $pickupDispatcher);
        $this->assertInstanceOf(IranPostPickupDispatcher::class, $pickupDispatcher);
    }

    public function testTipaxFactoryCreatesConsistentProductFamily(): void
    {
        $factory = new TipaxLogisticsFactory();

        $rateCalculator = $factory->createRateCalculator();
        $waybillGenerator = $factory->createWaybillGenerator();
        $pickupDispatcher = $factory->createPickupDispatcher();

        $this->assertInstanceOf(ShippingRateCalculatorInterface::class, $rateCalculator);
        $this->assertInstanceOf(TipaxRateCalculator::class, $rateCalculator);

        $this->assertInstanceOf(WaybillGeneratorInterface::class, $waybillGenerator);
        $this->assertInstanceOf(TipaxWaybillGenerator::class, $waybillGenerator);

        $this->assertInstanceOf(PickupDispatcherInterface::class, $pickupDispatcher);
        $this->assertInstanceOf(TipaxPickupDispatcher::class, $pickupDispatcher);
    }

    public function testOrderFulfillmentPipelineOrchestrationWithMockFactory(): void
    {
        // 1. Mock the products
        $rateCalculatorMock = $this->createMock(ShippingRateCalculatorInterface::class);
        $rateCalculatorMock->expects($this->once())
            ->method('calculate')
            ->with('9901', 3.5, 'Tabriz')
            ->willReturn(650000);

        $waybillGeneratorMock = $this->createMock(WaybillGeneratorInterface::class);
        $waybillGeneratorMock->expects($this->once())
            ->method('generate')
            ->with('9901')
            ->willReturn('TEST-TRACKING-9901');

        $pickupDispatcherMock = $this->createMock(PickupDispatcherInterface::class);
        $pickupDispatcherMock->expects($this->once())
            ->method('dispatch')
            ->with('9901')
            ->willReturn('DISPATCH-MOCK-9901');

        // 2. Mock the Abstract Factory
        $factoryMock = $this->createMock(LogisticsFactoryInterface::class);
        $factoryMock->expects($this->once())
            ->method('createRateCalculator')
            ->willReturn($rateCalculatorMock);
        $factoryMock->expects($this->once())
            ->method('createWaybillGenerator')
            ->willReturn($waybillGeneratorMock);
        $factoryMock->expects($this->once())
            ->method('createPickupDispatcher')
            ->willReturn($pickupDispatcherMock);

        // 3. Execute the pipeline
        $pipeline = new OrderFulfillmentPipeline($factoryMock);
        $result = $pipeline->fulfillOrder('9901', 3.5, 'Tabriz');

        // 4. Assert response contracts
        $this->assertSame('9901', $result['order_id']);
        $this->assertSame(650000, $result['cost_irr']);
        $this->assertSame('TEST-TRACKING-9901', $result['waybill']);
        $this->assertSame('DISPATCH-MOCK-9901', $result['dispatch_id']);
    }

}