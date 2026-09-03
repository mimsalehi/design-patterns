<?php

declare(strict_types=1);

namespace App\Structural\Bridge\Legacy;

/**
 * Legacy Anti-pattern: Hardcoded Cartesian combination of Payroll Slip + PDF output.
 */
class PayrollSlipPdfReport
{
    public function generate(string $employeeName, string $personnelId, int $baseSalary, int $overtimeBonus): string
    {
        $insurance = (int) ($baseSalary * 0.07);
        $netPayable = ($baseSalary + $overtimeBonus) - $insurance;

        echo sprintf("[PDF Engine] Compiling employee payroll slip to printable PDF layout...\n");

        return sprintf(
            "[PDF Document] === PAYROLL SLIP: %s (ID: %s) ===\n" .
            "| Base Salary: %s IRR\n" .
            "| Overtime: %s IRR\n" .
            "| Social Security (7%%): -%s IRR\n" .
            "| Net Remittance: %s IRR\n",
            $employeeName,
            $personnelId,
            number_format($baseSalary),
            number_format($overtimeBonus),
            number_format($insurance),
            number_format($netPayable)
        );
    }
}
