<?php

namespace App\Creational\AbstractFactory;

use App\Creational\AbstractFactory\PickupDispatcherInterface;

class TipaxPickupDispatcher implements PickupDispatcherInterface
{

    public function __construct(
        private string $localBranchCode = 'TPX-BR-882'
    ) {
    }

    public function dispatch(string $orderId): string
    {
        $dispatchCode = 'TPX-DISPATCH-' . $orderId . '-' . rand(100, 999);

        echo sprintf(
            "[Tipax Pickup] Scheduled express pickup with branch [%s]. Dispatch reference: %s\n",
            $this->localBranchCode,
            $dispatchCode
        );

        return $dispatchCode;
    }

}