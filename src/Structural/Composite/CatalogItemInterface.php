<?php

declare(strict_types=1);

namespace App\Structural\Composite;

interface CatalogItemInterface
{
    public function getTitle(): string;

    public function getDurationMinutes(): int;
}
