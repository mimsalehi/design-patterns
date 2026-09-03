<?php

declare(strict_types=1);

namespace App\Structural\Bridge;

/**
 * Step 4: Refined Abstraction 2 (فیش حقوق و دستمزد پرسنل)
 */
class PayrollSlipReport extends FinancialReport
{
    public function __construct(
        ReportRendererInterface $renderer,
        private string $employeeName,
        private string $personnelId,
        private int $baseSalaryIrr,
        private int $overtimeBonusIrr,
        private float $socialSecurityInsuranceRate = 0.07
    ) {
        parent::__construct($renderer);
    }

    public function export(): string
    {
        $insuranceDeduction = (int) ($this->baseSalaryIrr * $this->socialSecurityInsuranceRate);
        $netPayable = ($this->baseSalaryIrr + $this->overtimeBonusIrr) - $insuranceDeduction;

        $this->renderer->reset();
        $this->renderer->renderHeader(sprintf("Payroll Slip - %s (ID: %s)", $this->employeeName, $this->personnelId));
        $this->renderer->renderRow("Base Monthly Salary", number_format($this->baseSalaryIrr) . " IRR");
        $this->renderer->renderRow("Overtime Bonus", number_format($this->overtimeBonusIrr) . " IRR");
        $this->renderer->renderRow(sprintf("Social Security (7%%)"), "-" . number_format($insuranceDeduction) . " IRR");
        $this->renderer->renderFooter(sprintf("Net Remittance: %s IRR", number_format($netPayable)));

        return $this->renderer->getFormattedOutput();
    }
}
