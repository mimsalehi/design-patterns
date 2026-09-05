<?php

declare(strict_types=1);

namespace App\Structural\Decorator;

final class StandardAd implements AdInterface
{
    public function __construct(
        private string $title,
        private int $baseCostIrr = 0
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCostIrr(): int
    {
        return $this->baseCostIrr;
    }

    public function render(): string
    {
        return "[STANDARD] " . $this->title;
    }
}
