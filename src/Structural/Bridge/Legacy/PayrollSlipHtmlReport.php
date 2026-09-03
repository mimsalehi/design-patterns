<?php

declare(strict_types=1);

namespace App\Structural\Bridge\Legacy;

/**
 * Legacy Anti-pattern: Hardcoded Cartesian combination of Payroll Slip + HTML output.
 */
class PayrollSlipHtmlReport
{
    public function generate(string $employeeName, string $personnelId, int $baseSalary, int $overtimeBonus): string
    {
        $insurance = (int) ($baseSalary * 0.07);
        $netPayable = ($baseSalary + $overtimeBonus) - $insurance;

        echo sprintf("[HTML Engine] Exporting employee payroll records into spreadsheet columns...\n");

        return sprintf(
            "[HTML Spreadsheet] Sheet 'Payroll' | Row: ['%s', '%s', %d, %d, %d, %d] | Ready for treasury.\n",
            $employeeName,
            $personnelId,
            $baseSalary,
            $overtimeBonus,
            $insurance,
            $netPayable
        );
    }
}
