<?php

declare(strict_types=1);

namespace App\Creational\Prototype;

class CoveragePackage
{
    public function __construct(
        private int $legalLiabilityIrr = 12000000000,
        private int $driverAccidentIrr = 9000000000,
        private int $financialLimitIrr = 400000000,
        private int $fleetDiscountPercentage = 15
    ) {
    }

    public function setFinancialLimitIrr(int $limit): void
    {
        $this->financialLimitIrr = $limit;
    }

    public function getFinancialLimitIrr(): int
    {
        return $this->financialLimitIrr;
    }

    public function getLegalLiabilityIrr(): int
    {
        return $this->legalLiabilityIrr;
    }

    public function getDriverAccidentIrr(): int
    {
        return $this->driverAccidentIrr;
    }

    public function getFleetDiscountPercentage(): int
    {
        return $this->fleetDiscountPercentage;
    }

    public function __clone()
    {
    }
}
