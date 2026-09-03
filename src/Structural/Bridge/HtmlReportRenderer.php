<?php

declare(strict_types=1);

namespace App\Structural\Bridge;

/**
 * Step 2: Concrete Implementor 3 (موتور رندر وب HTML)
 */
class HtmlReportRenderer implements ReportRendererInterface
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
        $this->buffer .= sprintf("<div class=\"report-card\">\n");
        $this->buffer .= sprintf("  <header><h3>%s</h3></header>\n", htmlspecialchars($title));
        $this->buffer .= sprintf("  <table class=\"table-striped\">\n");
    }

    public function renderRow(string $label, string $value): void
    {
        $this->buffer .= sprintf("    <tr><td>%s</td><td><strong>%s</strong></td></tr>\n", htmlspecialchars($label), htmlspecialchars($value));
    }

    public function renderFooter(string $summary): void
    {
        $this->buffer .= sprintf("  </table>\n");
        $this->buffer .= sprintf("  <footer><p class=\"badge\">%s</p></footer>\n", htmlspecialchars($summary));
        $this->buffer .= sprintf("</div>\n\n");
    }

    public function getFormattedOutput(): string
    {
        return $this->buffer;
    }
}
