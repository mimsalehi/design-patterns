<?php

declare(strict_types=1);

namespace App\Creational\Prototype;

interface PolicyPrototypeInterface
{
    /**
     * Clones the current policy with full deep copy of nested objects.
     */
    public function clone(): self;
}
