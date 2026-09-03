<?php

declare(strict_types=1);

namespace App\Tests;

use App\Structural\Bridge\ExcelReportRenderer;
use App\Structural\Bridge\HtmlReportRenderer;
use App\Structural\Bridge\PayrollSlipReport;
use App\Structural\Bridge\PdfReportRenderer;
use App\Structural\Bridge\ReportRendererInterface;
use App\Structural\Bridge\TaxInvoiceReport;
use PHPUnit\Framework\TestCase;

class BridgeTest extends TestCase
{
    public function testTaxInvoiceReportRendersCorrectlyWithPdfRenderer(): void
    {
        $renderer = new PdfReportRenderer();
        $report = new TaxInvoiceReport($renderer, 'TX-101', 10000000, 0.10);

        $output = $report->export();

        $this->assertStringContainsString('OFFICIAL TAX INVOICE #TX-101', $output);
        $this->assertStringContainsString('Base Amount', $output);
        $this->assertStringContainsString('10,000,000 IRR', $output);
        $this->assertStringContainsString('VAT (10%)', $output);
        $this->assertStringContainsString('1,000,000 IRR', $output);
        $this->assertStringContainsString('Total Payable: 11,000,000 IRR', $output);
        $this->assertStringContainsString('PDF Engine', $output);
    }

    public function testTaxInvoiceReportSwitchesRendererAtRuntime(): void
    {
        $pdfRenderer = new PdfReportRenderer();
        $excelRenderer = new ExcelReportRenderer();

        $report = new TaxInvoiceReport($pdfRenderer, 'TX-202', 20000000, 0.10);

        // 1. Initial PDF output
        $pdfOutput = $report->export();
        $this->assertStringContainsString('PDF Engine', $pdfOutput);
        $this->assertSame($pdfRenderer, $report->getRenderer());

        // 2. Switch to Excel at runtime
        $report->setRenderer($excelRenderer);
        $excelOutput = $report->export();

        $this->assertStringContainsString('Excel Spreadsheet Engine', $excelOutput);
        $this->assertSame($excelRenderer, $report->getRenderer());
    }

    public function testPayrollSlipReportRendersCorrectlyWithHtmlRenderer(): void
    {
        $htmlRenderer = new HtmlReportRenderer();
        $payroll = new PayrollSlipReport($htmlRenderer, 'Sara Rad', 'EMP-99', 40000000, 5000000);

        $output = $payroll->export();

        $this->assertStringContainsString('<div class="report-card">', $output);
        $this->assertStringContainsString('Sara Rad', $output);
        $this->assertStringContainsString('EMP-99', $output);
        $this->assertStringContainsString('40,000,000 IRR', $output);
        $this->assertStringContainsString('Social Security (7%)', $output);
        // 40M + 5M - (40M * 0.07 = 2.8M) = 42.2M
        $this->assertStringContainsString('Net Remittance: 42,200,000 IRR', $output);
    }

    public function testPayrollSlipReportRendersCorrectlyWithPowerPointRenderer(): void
    {
        $powerPointRenderer = new \App\Structural\Bridge\PowerPointReportRenderer();
        $payroll = new PayrollSlipReport($powerPointRenderer, 'Reza Moradi', 'EMP-105', 50000000, 10000000);

        $output = $payroll->export();

        $this->assertStringContainsString('PowerPoint Slide Deck Engine', $output);
        $this->assertStringContainsString('Slide 1: Title & Overview', $output);
        $this->assertStringContainsString('Reza Moradi', $output);
        $this->assertStringContainsString('EMP-105', $output);
        $this->assertStringContainsString('Slide 2: Summary Card', $output);
    }

    public function testReportDelegatesToMockRendererContract(): void
    {
        $mockRenderer = $this->createMock(ReportRendererInterface::class);

        $mockRenderer->expects($this->once())->method('reset');
        $mockRenderer->expects($this->once())->method('renderHeader')->with($this->stringContains('TX-777'));
        $mockRenderer->expects($this->exactly(3))->method('renderRow');
        $mockRenderer->expects($this->once())->method('renderFooter')->with($this->stringContains('Total Payable'));
        $mockRenderer->expects($this->once())->method('getFormattedOutput')->willReturn('MOCK_OUTPUT_RESULT');

        $report = new TaxInvoiceReport($mockRenderer, 'TX-777', 1000000, 0.10);
        $result = $report->export();

        $this->assertSame('MOCK_OUTPUT_RESULT', $result);
    }
}
