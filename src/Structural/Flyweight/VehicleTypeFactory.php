<?php

declare(strict_types=1);

namespace App\Structural\Flyweight;

final class VehicleTypeFactory
{
    /** @var array<string, VehicleType> */
    private static array $vehicleTypes = [];

    public static function getVehicleType(
        string $modelName,
        string $color,
        string $category,
        string $manufacturer,
        string $iconSprite3d
    ): VehicleType {
        $key = sprintf('%s_%s_%s_%s', $modelName, $color, $category, $manufacturer);

        if (!isset(self::$vehicleTypes[$key])) {
            self::$vehicleTypes[$key] = new VehicleType(
                $modelName,
                $color,
                $category,
                $manufacturer,
                $iconSprite3d
            );
        }

        return self::$vehicleTypes[$key];
    }

    public static function getFlyweightCount(): int
    {
        return count(self::$vehicleTypes);
    }

    public static function reset(): void
    {
        self::$vehicleTypes = [];
    }
}
