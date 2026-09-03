<?php

declare(strict_types=1);

namespace App\Structural\Bridge\Legacy;

/**
 * Legacy Anti-pattern: Hardcoded Cartesian combination of Payroll Slip + Excel output.
 */
class PayrollSlipExcelReport
{
    public function generate(string $employeeName, string $personnelId, int $baseSalary, int $overtimeBonus): string
    {
        $insurance = (int) ($baseSalary * 0.07);
        $netPayable = ($baseSalary + $overtimeBonus) - $insurance;

        echo sprintf("[Excel Engine] Exporting employee payroll records into spreadsheet columns...\n");

        return sprintf(
            "[Excel Spreadsheet] Sheet 'Payroll' | Row: ['%s', '%s', %d, %d, %d, %d] | Ready for treasury.\n",
            $employeeName,
            $personnelId,
            $baseSalary,
            $overtimeBonus,
            $insurance,
            $netPayable
        );
    }
}
