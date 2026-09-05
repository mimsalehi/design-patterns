<?php

declare(strict_types=1);

namespace App\Structural\Decorator\Legacy;

final class LadderAd extends StandardAd
{
    public function getCostIrr(): int
    {
        return parent::getCostIrr() + 70000;
    }

    public function render(): string
    {
        return "[LADDER] " . parent::render();
    }
}
