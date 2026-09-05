<?php

declare(strict_types=1);

namespace App\Structural\Decorator\Legacy;

class StandardAd
{
    public function __construct(
        protected string $title,
        protected int $baseCostIrr
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
