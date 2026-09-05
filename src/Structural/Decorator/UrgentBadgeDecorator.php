<?php

declare(strict_types=1);

namespace App\Structural\Decorator;

final class UrgentBadgeDecorator extends AdDecorator
{
    private const URGENT_FEE_IRR = 50000;

    public function getCostIrr(): int
    {
        return $this->wrappee->getCostIrr() + self::URGENT_FEE_IRR;
    }

    public function render(): string
    {
        return "[URGENT] " . $this->wrappee->render();
    }
}
