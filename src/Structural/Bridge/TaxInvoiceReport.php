<?php

declare(strict_types=1);

namespace App\Structural\Bridge;

/**
 * Step 4: Refined Abstraction 1 (صورت‌حساب رسمی مالیاتی)
 */
class TaxInvoiceReport extends FinancialReport
{
    public function __construct(
        ReportRendererInterface $renderer,
        private string $invoiceNumber,
        private int $baseAmountIrr,
        private float $vatRate = 0.10,
        private string $buyerEconomicCode = '411892314522'
    ) {
        parent::__construct($renderer);
    }

    public function export(): string
    {
        $vatAmount = (int) ($this->baseAmountIrr * $this->vatRate);
        $totalPayable = $this->baseAmountIrr + $vatAmount;

        $this->renderer->reset();
        $this->renderer->renderHeader(sprintf("Official Tax Invoice #%s", $this->invoiceNumber));
        $this->renderer->renderRow("Buyer Economic Code", $this->buyerEconomicCode);
        $this->renderer->renderRow("Base Amount", number_format($this->baseAmountIrr) . " IRR");
        $this->renderer->renderRow(sprintf("VAT (%d%%)", (int) ($this->vatRate * 100)), number_format($vatAmount) . " IRR");
        $this->renderer->renderFooter(sprintf("Total Payable: %s IRR", number_format($totalPayable)));

        return $this->renderer->getFormattedOutput();
    }
}
