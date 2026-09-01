<?php

namespace App\Creational\AbstractFactory;

use App\Creational\AbstractFactory\WaybillGeneratorInterface;

class IranPostWaybillGenerator implements WaybillGeneratorInterface
{

    public function generate(string $orderId): string
    {
        // Generates 24-digit national postal barcode standard
        $barcode = 'POST-98' . str_pad($orderId, 16, '0', STR_PAD_LEFT);

        echo sprintf(
            "[Iran Post Waybill] Generated 24-digit barcode: [%s] (Label: Standard A5 Post Sheet)\n",
            $barcode
        );

        return $barcode;
    }
}