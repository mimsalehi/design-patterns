<?php

declare(strict_types=1);

namespace App\Structural\Decorator;

abstract class AdDecorator implements AdInterface
{
    public function __construct(
        protected AdInterface $wrappee
    ) {}

    public function getTitle(): string
    {
        return $this->wrappee->getTitle();
    }

    public function getCostIrr(): int
    {
        return $this->wrappee->getCostIrr();
    }

    public function render(): string
    {
        return $this->wrappee->render();
    }
}
