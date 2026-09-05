<?php

declare(strict_types=1);

namespace App\Structural\Flyweight;

final class VehicleMapMarker
{
    public function __construct(
        // Pointer to shared flyweight (Intrinsic state)
        private VehicleType $vehicleType,

        // Extrinsic state (Unique to this specific marker on the map)
        private string $plateNumber,
        private string $driverNationalCode,
        private float $latitude,
        private float $longitude,
        private int $bearingDegrees
    ) {}

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function getDriverNationalCode(): string
    {
        return $this->driverNationalCode;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getBearingDegrees(): int
    {
        return $this->bearingDegrees;
    }

    public function getVehicleType(): VehicleType
    {
        return $this->vehicleType;
    }

    public function updateCoordinates(float $latitude, float $longitude, int $bearingDegrees): void
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->bearingDegrees = $bearingDegrees;
    }

    public function render(): string
    {
        return $this->vehicleType->render(
            $this->plateNumber,
            $this->latitude,
            $this->longitude,
            $this->bearingDegrees
        );
    }
}
