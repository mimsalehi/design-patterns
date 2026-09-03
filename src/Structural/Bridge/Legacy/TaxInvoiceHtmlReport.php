<?php

declare(strict_types=1);

namespace App\Structural\Bridge\Legacy;

/**
 * Legacy Anti-pattern: Hardcoded Cartesian combination of Tax Invoice + HTML output.
 */
class TaxInvoiceHtmlReport
{
    public function generate(string $invoiceNumber, int $totalAmount, float $vatRate = 0.10): string
    {
        $vat = (int) ($totalAmount * $vatRate);
        $finalAmount = $totalAmount + $vat;

        echo sprintf("[HTML Engine] Exporting tax records into spreadsheet columns...\n");

        return sprintf(
            "[HTML Spreadsheet] Sheet 'Tax_Invoices' | Row: ['%s', %d, %d, %d] | Ready for accounting analysis.\n",
            $invoiceNumber,
            $totalAmount,
            $vat,
            $finalAmount
        );
    }
}
