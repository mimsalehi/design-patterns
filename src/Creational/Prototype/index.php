<?php

declare(strict_types=1);

use App\Creational\Prototype\CoveragePackage;
use App\Creational\Prototype\InsurancePolicyRegistry;
use App\Creational\Prototype\Legacy\PolicyIssuanceService;
use App\Creational\Prototype\VehicleInsurancePolicy;

$service = new PolicyIssuanceService();
$service->issueFleetPoliciesDirectly();


// ============================================================================
// 1. One-time heavy bootstrap: Load Sanhab tariffs and register master prototypes
// ============================================================================
echo "=== Step 1: Bootstrapping Insurance Prototype Registry ===\n";

$registry = new InsurancePolicyRegistry();

// Master Blueprint for Standard Delivery Fleet (e.g. Digikala / Snapp fleet)
$standardFleetCoverage = new CoveragePackage(
    legalLiabilityIrr: 12000000000,
    driverAccidentIrr: 9000000000,
    financialLimitIrr: 400000000, // 400M IRR base
    fleetDiscountPercentage: 15
);

$masterFleetPolicy = new VehicleInsurancePolicy(
    company: 'Bimeh Iran - Central Corporate Branch',
    taxRate: 0.09,
    coverage: $standardFleetCoverage
);

$registry->register('digikala_delivery_fleet', $masterFleetPolicy);
echo "Registered master prototype: [digikala_delivery_fleet]\n\n";

// ============================================================================
// 2. Fast cloning for Fleet Vehicle 1 (Standard Policy)
// ============================================================================
echo "=== Step 2: Issuing Policy for Vehicle 1 via Clone ===\n";
/** @var VehicleInsurancePolicy $policyVehicle1 */
$policyVehicle1 = $registry->get('digikala_delivery_fleet');
$policyVehicle1->setVehicleDetails(
    plateNumber: '12-A-345-IR77',
    chassisNumber: 'IR-KHODRO-CH-88410',
    driverNationalCode: '0019283741'
);

echo $policyVehicle1->getSummary() . "\n\n";

// ============================================================================
// 3. Fast cloning for Fleet Vehicle 2 (VIP Heavy Truck - Upgraded Coverage)
// ============================================================================
echo "=== Step 3: Issuing Policy for Vehicle 2 & Upgrading Financial Limit ===\n";
/** @var VehicleInsurancePolicy $policyVehicle2 */
$policyVehicle2 = $registry->get('digikala_delivery_fleet');
$policyVehicle2->setVehicleDetails(
    plateNumber: '88-B-992-IR77',
    chassisNumber: 'IR-KHODRO-CH-88411',
    driverNationalCode: '0019283742'
);

// Upgrade financial limit only for Vehicle 2
$policyVehicle2->getCoverage()->setFinancialLimitIrr(800000000); // 800M IRR

echo $policyVehicle2->getSummary() . "\n\n";

// ============================================================================
// 4. Verification of Memory Independence (Deep Copy Proof)
// ============================================================================
echo "=== Step 4: Verifying Vehicle 1 Remains Untouched (Zero Side-Effects) ===\n";
echo $policyVehicle1->getSummary() . "\n";

if ($policyVehicle1->getCoverage()->getFinancialLimitIrr() === 400000000) {
    echo "SUCCESS: Vehicle 1 financial limit is strictly preserved at 400,000,000 IRR!\n";
} else {
    echo "FAILED: Shallow copy bug detected! Vehicle 1 was mutated.\n";
}
