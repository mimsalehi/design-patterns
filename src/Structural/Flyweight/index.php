<?php

declare(strict_types=1);

use App\Structural\Flyweight\Legacy\VehicleMapMarker as LegacyVehicleMarker;
use App\Structural\Flyweight\VehicleMapMarker;
use App\Structural\Flyweight\VehicleTypeFactory;

$sampleModels = [
    ['model' => 'Peugeot 206', 'color' => 'White', 'category' => 'Snapp Eco', 'mfr' => 'Iran Khodro'],
    ['model' => 'Pride 131', 'color' => 'White', 'category' => 'Snapp Eco', 'mfr' => 'Saipa'],
    ['model' => 'Quick', 'color' => 'Black', 'category' => 'Snapp Plus', 'mfr' => 'Saipa'],
];

// Helper to simulate loading a 30KB 3D vector sprite
function loadTextureBuffer(string $model, string $color, int $vehicleId = 0): string
{
    return str_repeat("SPRITE_{$model}_{$color}_VECTOR_TEXTURE_DATA_", 800) . ($vehicleId > 0 ? "_{$vehicleId}" : '');
}

// ============================================================================
// 0. Legacy Approach: Naive Heavy Object Duplication in RAM
// ============================================================================
echo "=== 0. Legacy Approach: Naive Heavy Object Duplication in RAM ===\n";
echo "Notice: Every vehicle marker allocates its own 30KB texture buffer in RAM!\n\n";

$legacyStartMemory = memory_get_usage();
$legacyMarkers = [];
$totalVehicles = 1500;

for ($i = 1; $i <= $totalVehicles; $i++) {
    $spec = $sampleModels[$i % 3];

    // Each car independently loads its own 30KB texture buffer into memory
    $independentSpriteBuffer = loadTextureBuffer($spec['model'], $spec['color'], $i);

    $legacyMarkers[] = new LegacyVehicleMarker(
        plateNumber: sprintf('%02d-B-%03d-IR77', ($i % 89) + 10, ($i % 899) + 100),
        driverNationalCode: sprintf('001%07d', $i),
        latitude: 35.6892 + (($i % 100) / 10000),
        longitude: 51.3890 + (($i % 100) / 10000),
        bearingDegrees: ($i * 15) % 360,
        modelName: $spec['model'],
        color: $spec['color'],
        category: $spec['category'],
        manufacturer: $spec['mfr'],
        iconSprite3d: $independentSpriteBuffer
    );
}

$legacyMemoryBytes = memory_get_usage() - $legacyStartMemory;
$legacyMemoryMb = round($legacyMemoryBytes / 1024 / 1024, 2);

echo "Legacy Fleet Size: {$totalVehicles} active vehicles on Tehran map\n";
echo "Memory Consumed by Legacy Objects: {$legacyMemoryMb} MB\n";
echo "Sample Legacy Marker Output:\n";
echo "  " . $legacyMarkers[0]->render() . "\n\n";

// Free legacy memory before starting refactored benchmark
unset($legacyMarkers);
gc_collect_cycles();

// ============================================================================
// 1. Refactored Flyweight Approach: Shared Intrinsic Pool & Lightweight Context
// ============================================================================
echo "=== 1. Refactored Flyweight Pattern Approach (Shared Intrinsic Pool) ===\n";
echo "Notice: {$totalVehicles} markers share only 3 Flyweight objects in memory!\n\n";

VehicleTypeFactory::reset();
$flyweightStartMemory = memory_get_usage();
$flyweightMarkers = [];

for ($i = 1; $i <= $totalVehicles; $i++) {
    $spec = $sampleModels[$i % 3];

    // 1. Get or create shared flyweight instance from factory (loaded only once!)
    $vehicleType = VehicleTypeFactory::getVehicleType(
        modelName: $spec['model'],
        color: $spec['color'],
        category: $spec['category'],
        manufacturer: $spec['mfr'],
        iconSprite3d: loadTextureBuffer($spec['model'], $spec['color']) // Cached inside Flyweight pool!
    );

    // 2. Create lightweight marker containing only extrinsic state + pointer
    $flyweightMarkers[] = new VehicleMapMarker(
        vehicleType: $vehicleType,
        plateNumber: sprintf('%02d-B-%03d-IR77', ($i % 89) + 10, ($i % 899) + 100),
        driverNationalCode: sprintf('001%07d', $i),
        latitude: 35.6892 + (($i % 100) / 10000),
        longitude: 51.3890 + (($i % 100) / 10000),
        bearingDegrees: ($i * 15) % 360
    );
}

$flyweightMemoryBytes = memory_get_usage() - $flyweightStartMemory;
$flyweightMemoryMb = round($flyweightMemoryBytes / 1024 / 1024, 2);
$flyweightCount = VehicleTypeFactory::getFlyweightCount();

echo "Flyweight Fleet Size: {$totalVehicles} active vehicles on Tehran map\n";
echo "Distinct Flyweight Objects in RAM Pool: {$flyweightCount} instances\n";
echo "Memory Consumed by Flyweight Architecture: {$flyweightMemoryMb} MB\n";

if ($legacyMemoryBytes > 0) {
    $reductionPercent = round((1 - ($flyweightMemoryBytes / $legacyMemoryBytes)) * 100, 1);
    echo "RAM Optimization Achieved: {$reductionPercent}% memory reduction!\n";
}

echo "Sample Flyweight Marker Output:\n";
echo "  " . $flyweightMarkers[0]->render() . "\n";
echo "  " . $flyweightMarkers[1]->render() . "\n";
echo "  " . $flyweightMarkers[2]->render() . "\n\n";

// Real-time position update test without changing the flyweight
echo "Updating Marker #1 coordinates in real-time (car is moving):\n";
$flyweightMarkers[0]->updateCoordinates(35.7100, 51.4200, 90);
echo "  Updated Marker #1: " . $flyweightMarkers[0]->render() . "\n";
