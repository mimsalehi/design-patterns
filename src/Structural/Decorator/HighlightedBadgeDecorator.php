<?php

declare(strict_types=1);

namespace App\Structural\Decorator;

final class HighlightedBadgeDecorator extends AdDecorator
{
    private const HIGHLIGHT_FEE_IRR = 100000;

    public function getCostIrr(): int
    {
        return $this->wrappee->getCostIrr() + self::HIGHLIGHT_FEE_IRR;
    }

    public function render(): string
    {
        return "[HIGHLIGHTED] " . $this->wrappee->render();
    }
}
