<?php

declare(strict_types=1);

use App\Structural\Decorator\Legacy\LadderAd as LegacyLadderAd;
use App\Structural\Decorator\Legacy\StandardAd as LegacyStandardAd;
use App\Structural\Decorator\Legacy\UrgentAd as LegacyUrgentAd;
use App\Structural\Decorator\Legacy\UrgentLadderAd as LegacyUrgentLadderAd;
use App\Structural\Decorator\AdInterface;
use App\Structural\Decorator\HighlightedBadgeDecorator;
use App\Structural\Decorator\LadderDecorator;
use App\Structural\Decorator\StandardAd;
use App\Structural\Decorator\UrgentBadgeDecorator;

// ============================================================================
// 0. Legacy Approach: Inheritance Combinatorial Hell (2^N Subclasses)
// ============================================================================
echo "=== 0. Legacy Approach: Rigid Inheritance Combinatorial Hell ===\n";
echo "Notice: Every feature combination requires a dedicated subclass!\n\n";

$legacyAd1 = new LegacyStandardAd('Apartment 120m in Saadat Abad', 0);
echo $legacyAd1->render() . " | Fee: " . number_format($legacyAd1->getCostIrr()) . " IRR\n";

$legacyAd2 = new LegacyUrgentAd('iPhone 15 Pro Max 256GB', 0);
echo $legacyAd2->render() . " | Fee: " . number_format($legacyAd2->getCostIrr()) . " IRR\n";

$legacyAd3 = new LegacyLadderAd('Tehranpars Villa 300m', 0);
echo $legacyAd3->render() . " | Fee: " . number_format($legacyAd3->getCostIrr()) . " IRR\n";

$legacyAd4 = new LegacyUrgentLadderAd('Office Space in Jordan Street', 0);
echo $legacyAd4->render() . " | Fee: " . number_format($legacyAd4->getCostIrr()) . " IRR\n\n";

// ============================================================================
// 1. Refactored Decorator Approach: Dynamic Runtime Wrapping (N + 1 Classes)
// ============================================================================
echo "=== 1. Refactored Decorator Pattern Approach (Dynamic Object Wrapping) ===\n";
echo "Notice: Features are combined dynamically at runtime without new subclasses!\n\n";

function displayAd(AdInterface $ad): void
{
    echo $ad->render() . "\n";
    echo "  Total Promotion Fee: " . number_format($ad->getCostIrr()) . " IRR\n\n";
}

// Case A: Pure Standard Ad without any badges
echo "--- Case A: Plain Standard Ad ---\n";
$plainAd = new StandardAd('Apartment 120m in Saadat Abad', 0);
displayAd($plainAd);

// Case B: Ad decorated with Urgent badge
echo "--- Case B: Ad + Urgent Badge ---\n";
$urgentAd = new UrgentBadgeDecorator(
    new StandardAd('iPhone 15 Pro Max 256GB', 0)
);
displayAd($urgentAd);

// Case C: Ad decorated with both Urgent and Ladder badges
echo "--- Case C: Ad + Urgent + Ladder Badges ---\n";
$urgentLadderAd = new LadderDecorator(
    new UrgentBadgeDecorator(
        new StandardAd('Office Space in Jordan Street', 0)
    )
);
displayAd($urgentLadderAd);

// Case D: Premium Ad decorated with all three badges (Urgent + Ladder + Highlighted)
echo "--- Case D: Premium Ad (Urgent + Ladder + Highlighted) ---\n";
$vipAd = new HighlightedBadgeDecorator(
    new LadderDecorator(
        new UrgentBadgeDecorator(
            new StandardAd('Luxury Penthouse in Elahiyeh', 0)
        )
    )
);
displayAd($vipAd);

// Case E: Runtime dynamic decoration of an existing ad
echo "--- Case E: Dynamic Runtime Decoration (Upgrading an already published ad) ---\n";
$liveAd = new StandardAd('MacBook Pro M3 Max 64GB', 0);
echo "Initial publication:\n";
echo $liveAd->render() . " | Fee: " . number_format($liveAd->getCostIrr()) . " IRR\n";

// User decides 3 hours later to boost the ad with Ladder:
$liveAd = new LadderDecorator($liveAd);
echo "After applying Ladder:\n";
echo $liveAd->render() . " | Fee: " . number_format($liveAd->getCostIrr()) . " IRR\n";

// User decides next day to add Urgent badge on top of existing Ladder:
$liveAd = new UrgentBadgeDecorator($liveAd);
echo "After adding Urgent on top:\n";
echo $liveAd->render() . " | Fee: " . number_format($liveAd->getCostIrr()) . " IRR\n";
