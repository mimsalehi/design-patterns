<?php

declare(strict_types=1);

namespace App\Structural\Decorator;

final class LadderDecorator extends AdDecorator
{
    private const  LADDER_FEE_IRR = 70000;

    public function getCostIrr(): int
    {
        return $this->wrappee->getCostIrr() + self::LADDER_FEE_IRR;
    }

    public function render(): string
    {
        return "[LADDER] " . $this->wrappee->render();
    }
}
