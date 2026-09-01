<?php

namespace App\Creational\AbstractFactory;

interface WaybillGeneratorInterface
{
    public function generate(string $orderId): string;
}