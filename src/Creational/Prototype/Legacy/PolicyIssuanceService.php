<?php

declare(strict_types=1);

namespace App\Creational\Prototype\Legacy;

class PolicyIssuanceService
{
    public function issueFleetPoliciesDirectly(): void
    {
        // Heavy and expensive policy template initialization
        echo "[Sanhab API] Fetching central insurance regulatory tariffs and fleet discount matrix...\n";
        usleep(30000); // Simulating 300ms heavy network/DB payload / 0.3 sec

        $baseCoverage = [
            'legal_liability_irr' => 12000000000,
            'driver_accident_irr' => 9000000000,
            'financial_limit_irr' => 400000000,
            'fleet_discount_percentage' => 15,
        ];

        // Vehicle 1 Creation
        echo "\n[Policy Engine] Initializing new policy from scratch for Vehicle 1...\n";
        $policy1 = [
            'company' => 'Bimeh Iran - Central Branch',
            'tax_rate' => 0.09,
            'coverage' => $baseCoverage,
            'plate_number' => '12-A-345-IR77',
            'chassis_number' => 'IRAN-KHODRO-CH-88410',
            'driver_national_code' => '0019283741',
        ];

        // Vehicle 2 Creation (Re-executing everything or naive assignment)
        echo "[Policy Engine] Initializing new policy from scratch for Vehicle 2...\n";
        $policy2 = [
            'company' => 'Bimeh Iran - Central Branch',
            'tax_rate' => 0.09,
            'coverage' => $baseCoverage,
            'plate_number' => '88-B-992-IR77',
            'chassis_number' => 'IRAN-KHODRO-CH-88411',
            'driver_national_code' => '0019283742',
        ];

        echo sprintf(
            "[Issued] Policy 1 for Plate: %s (Financial Limit: %s IRR)\n",
            $policy1['plate_number'],
            number_format($policy1['coverage']['financial_limit_irr'])
        );

        echo sprintf(
            "[Issued] Policy 2 for Plate: %s (Financial Limit: %s IRR)\n\n",
            $policy2['plate_number'],
            number_format($policy2['coverage']['financial_limit_irr'])
        );
    }
}
