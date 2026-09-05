<?php

declare(strict_types=1);

namespace App\Structural\Decorator\Legacy;

final class UrgentLadderAd extends StandardAd
{
    public function getCostIrr(): int
    {
        return parent::getCostIrr() + 50000 + 70000;
    }

    public function render(): string
    {
        return "[URGENT] [LADDER] " . parent::render();
    }
}
