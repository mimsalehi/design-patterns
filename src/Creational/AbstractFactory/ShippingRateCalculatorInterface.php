<?php

namespace App\Creational\AbstractFactory;

interface ShippingRateCalculatorInterface
{
    public function calculate(string $orderId, float $weightInKg, string $destinationCity): int;
}