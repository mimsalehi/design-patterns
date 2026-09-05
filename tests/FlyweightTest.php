<?php

declare(strict_types=1);

namespace App\Tests;

use App\Structural\Flyweight\VehicleMapMarker;
use App\Structural\Flyweight\VehicleType;
use App\Structural\Flyweight\VehicleTypeFactory;
use PHPUnit\Framework\TestCase;

class FlyweightTest extends TestCase
{
    protected function setUp(): void
    {
        VehicleTypeFactory::reset();
    }

    public function testFactoryReturnsSameFlyweightInstanceForIdenticalSpecifications(): void
    {
        $flyweight1 = VehicleTypeFactory::getVehicleType('Peugeot 206', 'White', 'Snapp Eco', 'Iran Khodro', 'SPRITE_206');
        $flyweight2 = VehicleTypeFactory::getVehicleType('Peugeot 206', 'White', 'Snapp Eco', 'Iran Khodro', 'SPRITE_206');

        $this->assertSame($flyweight1, $flyweight2);
        $this->assertSame(1, VehicleTypeFactory::getFlyweightCount());
    }

    public function testFactoryCreatesDistinctFlyweightsForDifferentSpecifications(): void
    {
        $peugeot = VehicleTypeFactory::getVehicleType('Peugeot 206', 'White', 'Snapp Eco', 'Iran Khodro', 'SPRITE_206');
        $pride = VehicleTypeFactory::getVehicleType('Pride 131', 'White', 'Snapp Eco', 'Saipa', 'SPRITE_PRIDE');
        $quick = VehicleTypeFactory::getVehicleType('Quick', 'Black', 'Snapp Plus', 'Saipa', 'SPRITE_QUICK');

        $this->assertNotSame($peugeot, $pride);
        $this->assertNotSame($pride, $quick);
        $this->assertSame(3, VehicleTypeFactory::getFlyweightCount());
    }

    public function testMarkerRendersCombinedIntrinsicAndExtrinsicState(): void
    {
        $type = VehicleTypeFactory::getVehicleType('Peugeot 206', 'White', 'Snapp Eco', 'Iran Khodro', 'DUMMY_SPRITE');
        $marker = new VehicleMapMarker(
            vehicleType: $type,
            plateNumber: '12-B-345-IR77',
            driverNationalCode: '0019928371',
            latitude: 35.6892,
            longitude: 51.3890,
            bearingDegrees: 90
        );

        $rendered = $marker->render();

        $this->assertStringContainsString('Plate: 12-B-345-IR77', $rendered);
        $this->assertStringContainsString('Model: Peugeot 206 (White)', $rendered);
        $this->assertStringContainsString('Category: Snapp Eco', $rendered);
        $this->assertStringContainsString('Coord: (35.6892, 51.3890)', $rendered);
        $this->assertStringContainsString('Heading: 90 deg', $rendered);
    }

    public function testUpdatingMarkerCoordinatesDoesNotMutateSharedFlyweight(): void
    {
        $type = VehicleTypeFactory::getVehicleType('Peugeot 206', 'White', 'Snapp Eco', 'Iran Khodro', 'DUMMY_SPRITE');

        $marker1 = new VehicleMapMarker($type, '12-B-345-IR77', '0019928371', 35.6892, 51.3890, 45);
        $marker2 = new VehicleMapMarker($type, '88-A-992-IR77', '0019928372', 35.7000, 51.4000, 180);

        $this->assertSame($marker1->getVehicleType(), $marker2->getVehicleType());

        // Update coordinates of marker1 only
        $marker1->updateCoordinates(35.7200, 51.4500, 270);

        $this->assertSame(35.7200, $marker1->getLatitude());
        $this->assertSame(51.4500, $marker1->getLongitude());
        $this->assertSame(270, $marker1->getBearingDegrees());

        // Marker 2 coordinates remain completely unaffected
        $this->assertSame(35.7000, $marker2->getLatitude());
        $this->assertSame(51.4000, $marker2->getLongitude());
        $this->assertSame(180, $marker2->getBearingDegrees());
    }

    public function testFactoryResetWipesAllCachedFlyweights(): void
    {
        VehicleTypeFactory::getVehicleType('Samand', 'Yellow', 'Taxi', 'Iran Khodro', 'SPRITE');
        $this->assertSame(1, VehicleTypeFactory::getFlyweightCount());

        VehicleTypeFactory::reset();
        $this->assertSame(0, VehicleTypeFactory::getFlyweightCount());
    }
}
