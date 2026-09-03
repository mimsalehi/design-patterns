<?php

declare(strict_types=1);

namespace App\Structural\Bridge;

/**
 * Step 3: Base Abstraction (کلاس پایه انتزاع که پل Bridge را نگه می‌دارد)
 */
abstract class FinancialReport
{
    public function __construct(
        protected ReportRendererInterface $renderer
    ) {
    }

    /**
     * The Bridge feature: Switch output rendering engine dynamically at runtime!
     */
    public function setRenderer(ReportRendererInterface $renderer): void
    {
        $this->renderer = $renderer;
    }

    public function getRenderer(): ReportRendererInterface
    {
        return $this->renderer;
    }

    abstract public function export(): string;
}
