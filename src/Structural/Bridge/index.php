<?php

declare(strict_types=1);

use App\Structural\Bridge\ExcelReportRenderer;
use App\Structural\Bridge\HtmlReportRenderer;
use App\Structural\Bridge\Legacy\PayrollSlipExcelReport;
use App\Structural\Bridge\Legacy\PayrollSlipPdfReport;
use App\Structural\Bridge\Legacy\TaxInvoiceExcelReport;
use App\Structural\Bridge\Legacy\TaxInvoicePdfReport;
use App\Structural\Bridge\PayrollSlipReport;
use App\Structural\Bridge\PdfReportRenderer;
use App\Structural\Bridge\PowerPointReportRenderer;
use App\Structural\Bridge\TaxInvoiceReport;

// ============================================================================
// 0. Legacy Approach: Cartesian Product Class Explosion (N x M Classes)
// ============================================================================
echo "=== 0. Legacy Approach: Cartesian Class Explosion ===\n";
echo "Notice: Every report requires a dedicated class for every output format!\n\n";

$invoiceNumber = 'TX-1403-9981';
$amount = 50000000;

$taxPdf = new TaxInvoicePdfReport();
echo $taxPdf->generate($invoiceNumber, $amount, 0.10) . "\n";

$taxExcel = new TaxInvoiceExcelReport();
echo $taxExcel->generate($invoiceNumber, $amount, 0.10) . "\n";

$payrollPdf = new PayrollSlipPdfReport();
echo $payrollPdf->generate('Masoud Salehi', 'EMP-402', 35000000, 8000000) . "\n";

$payrollExcel = new PayrollSlipExcelReport();
echo $payrollExcel->generate('Masoud Salehi', 'EMP-402', 35000000, 8000000) . "\n";

// ============================================================================
// 1. Refactored Bridge Approach: Decoupled Abstraction & Implementation
// ============================================================================
echo "=== 1. Refactored Bridge Pattern Approach (N + M Linear Classes) ===\n";

// Engine 1: PDF Renderer
$pdfRenderer = new PdfReportRenderer();
// Engine 2: Excel Renderer
$excelRenderer = new ExcelReportRenderer();
// Engine 3: HTML Web Renderer
$htmlRenderer = new HtmlReportRenderer();

$powerPoint = new PowerPointReportRenderer();

// --- Scenario A: Tax Invoice exported to PDF ---
$taxReport = new TaxInvoiceReport($pdfRenderer, 'TX-1403-9981', 50000000, 0.10);
echo $taxReport->export();

// --- Scenario B: Dynamic Runtime Switching (Switching same report from PDF to Excel!) ---
echo ">>> Runtime Switching: Changing Tax Invoice Renderer to Excel without changing report object! <<<\n";
$taxReport->setRenderer($excelRenderer);
echo $taxReport->export();

// --- Scenario C: Payroll Slip exported to HTML Web Dashboard ---
$payrollReport = new PayrollSlipReport($htmlRenderer, 'Masoud Salehi', 'EMP-402', 35000000, 8000000);
echo $payrollReport->export();


echo ">>> Runtime Switching: Payroll Slip Renderer to Excel without changing report object! <<<\n";
$payrollReport->setRenderer($excelRenderer);
echo $payrollReport->export();


echo ">>> Runtime Switching: Payroll Slip Renderer to Powerpoint without changing report object! <<<\n";
$payrollReport->setRenderer($powerPoint);
echo $payrollReport->export();
