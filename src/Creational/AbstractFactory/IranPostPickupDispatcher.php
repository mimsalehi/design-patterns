<?php

namespace App\Creational\AbstractFactory;

use App\Creational\AbstractFactory\PickupDispatcherInterface;

class IranPostPickupDispatcher implements PickupDispatcherInterface
{

    public function __construct(
        private string $postalDistrict = 'District-14-Tehran-Hub'
    ) {
    }

    public function dispatch(string $orderId): string
    {
        $manifestId = 'MANIFEST-POST-' . $orderId . '-' . time();

        echo sprintf(
            "[Iran Post Pickup] Registered manifest [%s] in %s. Scheduled for postman pickup.\n",
            $manifestId,
            $this->postalDistrict
        );

        return $manifestId;
    }

}