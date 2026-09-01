<?php

declare(strict_types=1);

namespace App\Creational\AbstractFactory\Legacy;

use InvalidArgumentException;

class OrderFulfillmentService
{
    public function fulfill(string $carrier, string $orderId, float $weightInKg, string $destinationCity): void
    {
        if ($carrier === 'iran_post') {
            // 1. Iran Post Tariff Rate Calculator
            $baseTariff = 350000; // IRR
            $insuranceRate = 50000;
            $totalShippingCost = $baseTariff + ($weightInKg * 120000) + $insuranceRate;

            echo sprintf(
                "[Iran Post Rate] Calculated shipping cost for order '%s' to %s (%0.2f kg): %d IRR\n",
                $orderId,
                $destinationCity,
                $weightInKg,
                $totalShippingCost
            );

            // 2. Iran Post 24-digit Barcode & Waybill Generator
            $nationalPostBarcode = 'POST-98' . str_pad($orderId, 16, '0', STR_PAD_LEFT);
            echo sprintf(
                "[Iran Post Waybill] Generated 24-digit standard tracking barcode: [%s] (Label: Standard A5 Post Label)\n",
                $nationalPostBarcode
            );

            // 3. Iran Post Manifest & Collector Dispatcher
            $postOfficeDistrict = 'District-14-Tehran-Hub';
            echo sprintf(
                "[Iran Post Pickup] Registered manifest in Post Portal for %s. Awaiting postman collection.\n\n",
                $postOfficeDistrict
            );

        } elseif ($carrier === 'tipax') {
            // 1. Tipax Express Zone Calculator
            $baseZoneFee = 750000; // IRR
            $fragileHandlingFee = 150000;
            $totalShippingCost = $baseZoneFee + ($weightInKg * 210000) + $fragileHandlingFee;

            echo sprintf(
                "[Tipax Express Rate] Calculated express courier fee for order '%s' to %s (%0.2f kg): %d IRR\n",
                $orderId,
                $destinationCity,
                $weightInKg,
                $totalShippingCost
            );

            // 2. Tipax 12-digit Tracking Label Generator
            $tipaxTrackingCode = 'TPX-' . rand(10000000, 99999999);
            echo sprintf(
                "[Tipax Waybill] Issued Tipax express consignment note: [%s] (Label: Thermal Roll 100x150mm)\n",
                $tipaxTrackingCode
            );

            // 3. Tipax Courier Dispatcher
            $tipaxBranchCode = 'TPX-BR-882';
            echo sprintf(
                "[Tipax Pickup] Scheduled priority pickup with local branch (%s). Courier dispatch code: TPX-DISPATCH-%s\n\n",
                $tipaxBranchCode,
                $orderId
            );

        } else {
            throw new InvalidArgumentException(sprintf('Unsupported logistics carrier: [%s]', $carrier));
        }
    }
}