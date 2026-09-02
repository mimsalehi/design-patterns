<?php

declare(strict_types=1);

namespace App\Creational\Prototype;

use InvalidArgumentException;

class InsurancePolicyRegistry
{
    /**
     * @var array<string, PolicyPrototypeInterface>
     */
    private array $prototypes = [];

    public function register(string $key, PolicyPrototypeInterface $prototype): void
    {
        $this->prototypes[$key] = $prototype;
    }

    public function get(string $key): PolicyPrototypeInterface
    {
        if (!isset($this->prototypes[$key])) {
            throw new InvalidArgumentException(sprintf('No prototype registered for key: [%s]', $key));
        }

        // Returns a fresh deep clone of the requested prototype
        return $this->prototypes[$key]->clone();
    }

    public function has(string $key): bool
    {
        return isset($this->prototypes[$key]);
    }
}
