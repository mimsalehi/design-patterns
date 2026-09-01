<?php

namespace App\Creational\AbstractFactory;

use App\Creational\AbstractFactory\ShippingRateCalculatorInterface;

class IranPostRateCalculator implements ShippingRateCalculatorInterface
{

    public function __construct(
        private int $baseTariff = 350000,
        private int $perKgRate = 120000,
        private int $insuranceFee = 50000
    ) {
    }


    public function calculate(string $orderId, float $weightInKg, string $destinationCity): int
    {
        $calculatedTotal = (int) ($this->baseTariff + ($weightInKg * $this->perKgRate) + $this->insuranceFee);

        echo sprintf(
            "[Iran Post Rate] Order #%s to %s (%0.2f kg) calculated tariff: %s IRR\n",
            $orderId,
            $destinationCity,
            $weightInKg,
            number_format($calculatedTotal)
        );

        return $calculatedTotal;

    }
}