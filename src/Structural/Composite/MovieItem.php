<?php

declare(strict_types=1);

namespace App\Structural\Composite;

final class MovieItem implements CatalogItemInterface
{
    public function __construct(
        private string $title,
        private int $durationMinutes
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDurationMinutes(): int
    {
        return $this->durationMinutes;
    }
}
