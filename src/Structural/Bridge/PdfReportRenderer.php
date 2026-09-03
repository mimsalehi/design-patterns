<?php

declare(strict_types=1);

namespace App\Structural\Bridge;

/**
 * Step 2: Concrete Implementor 1 (موتور رندر PDF چاپی)
 */
class PdfReportRenderer implements ReportRendererInterface
{
    private string $buffer = '';

    public function __construct()
    {
        $this->reset();
    }

    public function reset(): void
    {
        $this->buffer = '';
    }

    public function renderHeader(string $title): void
    {
        $this->buffer .= sprintf("[PDF Engine - A4 Standard Persian RTL]\n");
        $this->buffer .= sprintf("====================================================\n");
        $this->buffer .= sprintf(" %s\n", strtoupper($title));
        $this->buffer .= sprintf("====================================================\n");
    }

    public function renderRow(string $label, string $value): void
    {
        $this->buffer .= sprintf("| %-25s : %s\n", $label, $value);
    }

    public function renderFooter(string $summary): void
    {
        $this->buffer .= sprintf("----------------------------------------------------\n");
        $this->buffer .= sprintf("| Summary: %s\n", $summary);
        $this->buffer .= sprintf("====================================================\n\n");
    }

    public function getFormattedOutput(): string
    {
        return $this->buffer;
    }
}
