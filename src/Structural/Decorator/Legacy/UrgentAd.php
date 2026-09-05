<?php

declare(strict_types=1);

namespace App\Structural\Decorator\Legacy;

final class UrgentAd extends StandardAd
{
    public function getCostIrr(): int
    {
        return parent::getCostIrr() + 50000;
    }

    public function render(): string
    {
        return "[URGENT] " . parent::render();
    }
}
