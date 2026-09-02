<?php

declare(strict_types=1);

namespace App\Tests;

use App\Creational\Prototype\CoveragePackage;
use App\Creational\Prototype\InsurancePolicyRegistry;
use App\Creational\Prototype\VehicleInsurancePolicy;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PrototypeTest extends TestCase
{
    public function testDeepCloningCreatesIndependentCoverageInstances(): void
    {
        // 1. Arrange: Create master prototype
        $originalCoverage = new CoveragePackage(
            legalLiabilityIrr: 12000000000,
            driverAccidentIrr: 9000000000,
            financialLimitIrr: 400000000,
            fleetDiscountPercentage: 15
        );

        $originalPolicy = new VehicleInsurancePolicy(
            company: 'Bimeh Iran',
            taxRate: 0.09,
            coverage: $originalCoverage
        );
        $originalPolicy->setVehicleDetails('11-A-111-IR77', 'CH-111', '0011111111');

        // 2. Act: Clone the policy and mutate clone's nested coverage
        $clonedPolicy = $originalPolicy->clone();
        $clonedPolicy->setVehicleDetails('22-B-222-IR77', 'CH-222', '0022222222');
        $clonedPolicy->getCoverage()->setFinancialLimitIrr(800000000);

        // 3. Assert: Memory references must be completely decoupled (Different RAM pointers)
        $this->assertNotSame($originalPolicy, $clonedPolicy);
        $this->assertNotSame($originalPolicy->getCoverage(), $clonedPolicy->getCoverage());

        // 4. Assert: Value state independence (Mutating clone did not touch original)
        $this->assertSame(400000000, $originalPolicy->getCoverage()->getFinancialLimitIrr());
        $this->assertSame(800000000, $clonedPolicy->getCoverage()->getFinancialLimitIrr());

        // 5. Assert: Vehicle specific fields are independent
        $this->assertSame('11-A-111-IR77', $originalPolicy->getPlateNumber());
        $this->assertSame('22-B-222-IR77', $clonedPolicy->getPlateNumber());
    }

    public function testRegistryStoresAndReturnsIndependentClones(): void
    {
        $registry = new InsurancePolicyRegistry();

        $baseCoverage = new CoveragePackage(financialLimitIrr: 500000000);
        $prototype = new VehicleInsurancePolicy(
            company: 'Alborz Insurance',
            taxRate: 0.09,
            coverage: $baseCoverage
        );

        $registry->register('corporate_fleet', $prototype);

        $this->assertTrue($registry->has('corporate_fleet'));
        $this->assertFalse($registry->has('non_existent_key'));

        /** @var VehicleInsurancePolicy $firstClone */
        $firstClone = $registry->get('corporate_fleet');
        /** @var VehicleInsurancePolicy $secondClone */
        $secondClone = $registry->get('corporate_fleet');

        // Verify that registry returns fresh clones, not the registered master instance
        $this->assertNotSame($prototype, $firstClone);
        $this->assertNotSame($firstClone, $secondClone);
        $this->assertNotSame($firstClone->getCoverage(), $secondClone->getCoverage());

        // Mutate first clone and verify second clone remains unaffected
        $firstClone->getCoverage()->setFinancialLimitIrr(990000000);
        $this->assertSame(990000000, $firstClone->getCoverage()->getFinancialLimitIrr());
        $this->assertSame(500000000, $secondClone->getCoverage()->getFinancialLimitIrr());
    }

    public function testRegistryThrowsExceptionOnUnregisteredKey(): void
    {
        $registry = new InsurancePolicyRegistry();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('No prototype registered for key: [unknown_fleet]');

        $registry->get('unknown_fleet');
    }
}
