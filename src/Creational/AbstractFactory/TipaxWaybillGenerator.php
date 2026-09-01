<?php

namespace App\Creational\AbstractFactory;

use App\Creational\AbstractFactory\WaybillGeneratorInterface;

class TipaxWaybillGenerator implements WaybillGeneratorInterface
{

    public function generate(string $orderId): string
    {
        // Generates 12-digit Tipax express consignment number
        $waybillCode = 'TPX-' . rand(10000000, 99999999);

        echo sprintf(
            "[Tipax Waybill] Issued express consignment note: [%s] (Label: Thermal Roll 100x150mm)\n",
            $waybillCode
        );

        return $waybillCode;

    }
}