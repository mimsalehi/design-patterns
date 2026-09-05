<?php

declare(strict_types=1);

namespace App\Structural\Flyweight;

final readonly class VehicleType
{
    public function __construct(
        private string $modelName,
        private string $color,
        private string $category,
        private string $manufacturer,
        private string $iconSprite3d
    ) {}

    public function getModelName(): string
    {
        return $this->modelName;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function getIconSpriteSize(): int
    {
        return strlen($this->iconSprite3d);
    }

    /**
     * Renders marker by combining intrinsic state with supplied extrinsic context.
     */
    public function render(
        string $plateNumber,
        float $latitude,
        float $longitude,
        int $bearingDegrees
    ): string {
        return sprintf(
            "[FLYWEIGHT MARKER] Plate: %s | Model: %s (%s) | Category: %s | Coord: (%.4f, %.4f) | Heading: %d deg | SpriteSize: %d bytes",
            $plateNumber,
            $this->modelName,
            $this->color,
            $this->category,
            $latitude,
            $longitude,
            $bearingDegrees,
            strlen($this->iconSprite3d)
        );
    }
}
