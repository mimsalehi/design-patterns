<?php

declare(strict_types=1);

namespace App\Structural\Bridge\Legacy;

/**
 * Legacy Anti-pattern: Hardcoded Cartesian combination of Tax Invoice + PDF output.
 */
class TaxInvoicePdfReport
{
    public function generate(string $invoiceNumber, int $totalAmount, float $vatRate = 0.10): string
    {
        $vat = (int) ($totalAmount * $vatRate);
        $finalAmount = $totalAmount + $vat;

        echo sprintf("[PDF Engine] Compiling standard Iranian tax invoice to printable PDF layout...\n");

        return sprintf(
            "[PDF Document] === TAX INVOICE #%s ===\n" .
            "| Base Amount: %s IRR\n" .
            "| VAT (10%%): %s IRR\n" .
            "| Final Payable: %s IRR\n" .
            "| Output: Printable A4 with standard Persian RTL font.\n",
            $invoiceNumber,
            number_format($totalAmount),
            number_format($vat),
            number_format($finalAmount)
        );
    }
}
