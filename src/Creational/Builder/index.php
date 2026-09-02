<?php

declare(strict_types=1);

use App\Creational\Builder\FlightTicketDirector;
use App\Creational\Builder\Legacy\FlightTicket;
use App\Creational\Builder\StandardFlightTicketBuilder;

// ============================================================================
// Scenario 1: Standard passenger (No extra add-ons)
// Passing ugly multiple nulls and default parameters!
// ============================================================================
echo "=== Scenario 1: Standard Economy Ticket (Passing nulls) ===\n";
$standardTicket = new FlightTicket(
    'W5-1044',
    'THR (Tehran)',
    'MHD (Mashhad)',
    '2026-09-20 08:30',
    'Ali Rezaei',
    '0019283741',
    'ECONOMY',
    0,     // No extra baggage
    false, // No insurance
    false, // No CIP
    null,  // No special meal
    null   // No seat chosen
);
echo $standardTicket->getSummary() . "\n\n";

// ============================================================================
// Scenario 2: VIP Business Passenger with full add-ons
// ============================================================================
echo "=== Scenario 2: VIP Business Ticket ===\n";
$vipTicket = new FlightTicket(
    'W5-1044',
    'THR (Tehran)',
    'MHD (Mashhad)',
    '2026-09-20 08:30',
    'Masoud Salehi',
    '0028192831',
    'BUSINESS',
    20,    // 20kg extra baggage
    true,  // Saman Travel Insurance
    true,  // Mehrabad CIP Airport Lounge
    'Diabetic Meal',
    '1A'
);
echo $vipTicket->getSummary() . "\n";




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
    'Diabetic / Low-Sodium Meal',
);

echo $vipTicket->getSummary() . "\n";