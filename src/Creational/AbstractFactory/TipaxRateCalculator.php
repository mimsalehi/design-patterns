<?php

namespace App\Creational\AbstractFactory;

use App\Creational\AbstractFactory\ShippingRateCalculatorInterface;

class TipaxRateCalculator implements ShippingRateCalculatorInterface
{
    public function __construct(
        private int $baseZoneRate = 750000,
        private int $perKgZoneRate = 210000,
        private int $fragileHandlingFee = 150000
    ) {
    }

    public function calculate(string $orderId, float $weightInKg, string $destinationCity): int
    {
        $calculatedTotal = (int) ($this->baseZoneRate + ($weightInKg * $this->perKgZoneRate) + $this->fragileHandlingFee);

        echo sprintf(
            "[Tipax Express Rate] Order #%s to %s (%0.2f kg) calculated fee: %s IRR\n",
            $orderId,
            $destinationCity,
            $weightInKg,
            number_format($calculatedTotal)
        );

        return $calculatedTotal;
    }
}