<?php

declare(strict_types=1);

use App\Creational\Builder\FlightTicketDirector;
use App\Creational\Builder\Legacy\FlightTicket as LegacyFlightTicket;
use App\Creational\Builder\StandardFlightTicketBuilder;

// ============================================================================
// 0. Legacy approach comparison (Telescoping Constructor with multiple nulls)
// ============================================================================
echo "=== 0. Legacy Telescoping Constructor Approach ===\n";
$legacyTicket = new LegacyFlightTicket(
    'W5-1044',
    'THR (Tehran)',
    'MHD (Mashhad)',
    '2026-09-20 08:30',
    'Ali Rezaei',
    '0019283741',
    'ECONOMY',
    0,
    false,
    false,
    null,
    null
);
echo $legacyTicket->getSummary() . "\n\n";

// ============================================================================
// 1. Fluent Builder: Custom step-by-step assembly (Zero nulls passed!)
// ============================================================================
echo "=== 1. Custom Ticket via Fluent Builder (Zero nulls!) ===\n";
$builder = new StandardFlightTicketBuilder();

$customTicket = $builder
    ->setFlight('W5-1044', 'THR (Tehran)', 'KIH (Kish Island)', '2026-09-22 14:00')
    ->setPassenger('Masoud Salehi', '0019283741')
    ->setSeatClass('ECONOMY')
    ->addExtraBaggage(15)
    ->withTravelInsurance()
    ->selectSeat('12C')
    ->build();

echo $customTicket->getSummary() . "\n\n";

// ============================================================================
// 2. Director: Pre-configured Standard Economy Package
// ============================================================================
echo "=== 2. Standard Economy Ticket via Director ===\n";
$director = new FlightTicketDirector();

$standardTicket = $director->buildStandardEconomyTicket(
    $builder,
    'IR-420',
    'THR (Tehran)',
    'SYZ (Shiraz)',
    '2026-09-25 10:15',
    'Sara Mohammadi',
    '0078923412'
);

echo $standardTicket->getSummary() . "\n\n";

// ============================================================================
// 3. Director: Pre-configured VIP Business Package with CIP Lounge & Special Meal
// ============================================================================
echo "=== 3. VIP Business Package via Director (CIP Lounge Included) ===\n";
$vipTicket = $director->buildVipBusinessPackage(
    $builder,
    'W5-1044',
    'THR (Tehran)',
    'MHD (Mashhad)',
    '2026-09-28 19:30',
    'Dr. Kaveh Rad',
    '0034182910',
    '2A',
    'Diabetic / Low-Sodium Meal'
);

echo $vipTicket->getSummary() . "\n";
