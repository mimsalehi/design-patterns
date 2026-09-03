<?php

declare(strict_types=1);

namespace App\Structural\Bridge;

/**
 * Step 1: Implementor Interface (قرارداد موتورهای رندرینگ)
 * Defines the contract for all rendering engines (PDF, Excel, HTML).
 */
interface ReportRendererInterface
{
    public function renderHeader(string $title): void;

    public function renderRow(string $label, string $value): void;

    public function renderFooter(string $summary): void;

    public function getFormattedOutput(): string;

    public function reset(): void;
}
