<?php

namespace App\Creational\Prototype;

use App\Creational\Prototype\PolicyPrototypeInterface;

class VehicleInsurancePolicy implements PolicyPrototypeInterface
{
    private string $plateNumber = '';
    private string $chassisNumber = '';
    private string $driverNationalCode = '';

    public function __construct(
        private string $company,
        private float $taxRate,
        private CoveragePackage $coverage
    ) {
    }

    /**
     * Deep clone implementation: Decouples nested objects in memory.
     */
    public function __clone(): void
    {
        // 1. Deep clone the nested coverage object to decouple RAM reference
        $this->coverage = clone $this->coverage;

        // 2. Reset vehicle-specific fields for the fresh clone
        $this->plateNumber = '';
        $this->chassisNumber = '';
        $this->driverNationalCode = '';
    }


    /**
     * @inheritDoc
     */
    public function clone(): \App\Creational\Prototype\PolicyPrototypeInterface
    {
        return clone $this;
    }
    public function setVehicleDetails(string $plateNumber, string $chassisNumber, string $driverNationalCode): void
    {
        $this->plateNumber = $plateNumber;
        $this->chassisNumber = $chassisNumber;
        $this->driverNationalCode = $driverNationalCode;
    }


    public function getCoverage(): CoveragePackage
    {
        return $this->coverage;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function getChassisNumber(): string
    {
        return $this->chassisNumber;
    }

    public function getDriverNationalCode(): string
    {
        return $this->driverNationalCode;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function getTaxRate(): float
    {
        return $this->taxRate;
    }

    public function getSummary(): string
    {
        return sprintf(
            "Policy [%s] | Plate: %s | Chassis: %s | Driver: %s | Financial Limit: %s IRR (Coverage RAM ID: %d)",
            $this->company,
            $this->plateNumber,
            $this->chassisNumber,
            $this->driverNationalCode,
            number_format($this->coverage->getFinancialLimitIrr()),
            spl_object_id($this->coverage)
        );
    }

}