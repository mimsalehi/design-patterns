<?php

declare(strict_types=1);

namespace App\Structural\Decorator;

interface AdInterface
{
    public function getTitle(): string;

    public function getCostIrr(): int;

    public function render(): string;
}
