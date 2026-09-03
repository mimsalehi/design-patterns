<?php

declare(strict_types=1);

namespace App\Structural\Bridge;

/**
 * Concrete Implementor: Compiles reports into presentation slide deck format.
 */
class PowerPointReportRenderer implements ReportRendererInterface
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
        $this->buffer .= sprintf("[PowerPoint Slide Deck Engine] Slide Deck: '%s'\n", $title);
        $this->buffer .= sprintf("====================================================\n");
        $this->buffer .= sprintf("Slide 1: Title & Overview\n");
        $this->buffer .= sprintf("----------------------------------------------------\n");
    }

    public function renderRow(string $label, string $value): void
    {
        $this->buffer .= sprintf("  * Bullet Point: %-25s -> %s\n", $label, $value);
    }

    public function renderFooter(string $summary): void
    {
        $this->buffer .= sprintf("----------------------------------------------------\n");
        $this->buffer .= sprintf("Slide 2: Summary Card [%s]\n", $summary);
        $this->buffer .= sprintf("====================================================\n\n");
    }

    public function getFormattedOutput(): string
    {
        return $this->buffer;
    }
}
