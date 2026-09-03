<?php

declare(strict_types=1);

namespace App\Structural\Bridge;

/**
 * Step 2: Concrete Implementor 2 (موتور رندر اکسل شیت)
 */
class ExcelReportRenderer implements ReportRendererInterface
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
        $this->buffer .= sprintf("[Excel Spreadsheet Engine] Sheet 'Financial_Report'\n");
        $this->buffer .= sprintf("[Col A: Attribute]               \t[Col B: Value]\n");
        $this->buffer .= sprintf("--- Document: %s ---\n", $title);
    }

    public function renderRow(string $label, string $value): void
    {
        $this->buffer .= sprintf("%-30s \t%s\n", $label, $value);
    }

    public function renderFooter(string $summary): void
    {
        $this->buffer .= sprintf("----------------------------------------------------\n");
        $this->buffer .= sprintf("AGGREGATED_TOTAL                 \t%s\n\n", $summary);
    }

    public function getFormattedOutput(): string
    {
        return $this->buffer;
    }
}
