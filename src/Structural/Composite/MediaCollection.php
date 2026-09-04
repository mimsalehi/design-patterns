<?php

declare(strict_types=1);

namespace App\Structural\Composite;

final class MediaCollection implements CatalogItemInterface
{
    /** @var CatalogItemInterface[] */
    private array $items = [];

    public function __construct(
        private string $title
    ) {}

    public function add(CatalogItemInterface $item): void
    {
        $this->items[] = $item;
    }

    public function remove(CatalogItemInterface $item): void
    {
        $this->items = array_values(
            array_filter($this->items, static fn(CatalogItemInterface $i): bool => $i !== $item)
        );
    }

    /**
     * @return CatalogItemInterface[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDurationMinutes(): int
    {
        $totalMinutes = 0;

        foreach ($this->items as $item) {
            $totalMinutes += $item->getDurationMinutes();
        }

        return $totalMinutes;
    }
}
