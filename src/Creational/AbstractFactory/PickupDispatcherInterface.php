<?php

namespace App\Creational\AbstractFactory;

interface PickupDispatcherInterface
{
    public function dispatch(string $orderId): string;
}