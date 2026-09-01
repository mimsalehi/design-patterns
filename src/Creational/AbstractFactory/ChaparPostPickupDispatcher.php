<?php

namespace App\Creational\AbstractFactory;

use App\Creational\AbstractFactory\PickupDispatcherInterface;

class ChaparPostPickupDispatcher implements PickupDispatcherInterface
{

    public function __construct(
        private string $postalDistrict = 'Chapart-AZADI'
    ) {
    }

    public function dispatch(string $orderId): string
    {
        $manifestId = 'MANIFEST-CHAPAR-' . $orderId . '-' . time();

        echo sprintf(
            "[CHAPAR Pickup] Registered manifest [%s] in %s. Scheduled for postman pickup.\n",
            $manifestId,
            $this->postalDistrict
        );

        return $manifestId;
    }

}