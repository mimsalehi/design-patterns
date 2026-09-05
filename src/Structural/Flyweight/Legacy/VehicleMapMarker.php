<?php

declare(strict_types=1);

namespace App\Structural\Flyweight\Legacy;

final class VehicleMapMarker
{
    public function __construct(
        // Extrinsic State (Unique per vehicle marker)
        private string $plateNumber,
        private string $driverNationalCode,
        private float $latitude,
        private float $longitude,
        private int $bearingDegrees,

        // Intrinsic State (Duplicated heavy data)
        private string $modelName,
        private string $color,
        private string $category,
        private string $manufacturer,
        private string $iconSprite3d
    ) {}

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function render(): string
    {
        return sprintf(
            "[LEGACY MARKER] Plate: %s | Model: %s (%s) | Category: %s | Coord: (%.4f, %.4f) | Heading: %d deg | SpriteSize: %d bytes",
            $this->plateNumber,
            $this->modelName,
            $this->color,
            $this->category,
            $this->latitude,
            $this->longitude,
            $this->bearingDegrees,
            strlen($this->iconSprite3d)
        );
    }
}
