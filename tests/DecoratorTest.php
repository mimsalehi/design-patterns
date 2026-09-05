<?php

declare(strict_types=1);

namespace App\Tests;

use App\Structural\Decorator\AdInterface;
use App\Structural\Decorator\HighlightedBadgeDecorator;
use App\Structural\Decorator\LadderDecorator;
use App\Structural\Decorator\StandardAd;
use App\Structural\Decorator\UrgentBadgeDecorator;
use PHPUnit\Framework\TestCase;

class DecoratorTest extends TestCase
{
    public function testStandardAdRendersCorrectlyWithoutDecorators(): void
    {
        $ad = new StandardAd('Samsung S24 Ultra', 0);

        $this->assertInstanceOf(AdInterface::class, $ad);
        $this->assertSame('Samsung S24 Ultra', $ad->getTitle());
        $this->assertSame(0, $ad->getCostIrr());
        $this->assertSame('[STANDARD] Samsung S24 Ultra', $ad->render());
    }

    public function testUrgentBadgeDecoratorAddsFeeAndTag(): void
    {
        $ad = new UrgentBadgeDecorator(new StandardAd('PlayStation 5', 0));

        $this->assertInstanceOf(AdInterface::class, $ad);
        $this->assertSame('PlayStation 5', $ad->getTitle());
        $this->assertSame(50000, $ad->getCostIrr());
        $this->assertSame('[URGENT] [STANDARD] PlayStation 5', $ad->render());
    }

    public function testLadderDecoratorAddsFeeAndTag(): void
    {
        $ad = new LadderDecorator(new StandardAd('Used Bicycle', 0));

        $this->assertSame('Used Bicycle', $ad->getTitle());
        $this->assertSame(70000, $ad->getCostIrr());
        $this->assertSame('[LADDER] [STANDARD] Used Bicycle', $ad->render());
    }

    public function testHighlightedBadgeDecoratorAddsFeeAndTag(): void
    {
        $ad = new HighlightedBadgeDecorator(new StandardAd('Yamaha Motorcycle', 0));

        $this->assertSame('Yamaha Motorcycle', $ad->getTitle());
        $this->assertSame(100000, $ad->getCostIrr());
        $this->assertSame('[HIGHLIGHTED] [STANDARD] Yamaha Motorcycle', $ad->render());
    }

    public function testCombinedDecoratorsAggregateFeesAndTags(): void
    {
        $ad = new HighlightedBadgeDecorator(
            new LadderDecorator(
                new UrgentBadgeDecorator(
                    new StandardAd('Villa in Ramsar', 20000)
                )
            )
        );

        // 20,000 (Base) + 50,000 (Urgent) + 70,000 (Ladder) + 100,000 (Highlighted) = 240,000 IRR
        $this->assertSame(240000, $ad->getCostIrr());
        $this->assertSame('[HIGHLIGHTED] [LADDER] [URGENT] [STANDARD] Villa in Ramsar', $ad->render());
    }

    public function testRuntimeDynamicDecorationSteps(): void
    {
        $ad = new StandardAd('Toyota Camry 2020', 0);
        $this->assertSame(0, $ad->getCostIrr());
        $this->assertSame('[STANDARD] Toyota Camry 2020', $ad->render());

        // Step 1: User adds Ladder
        $ad = new LadderDecorator($ad);
        $this->assertSame(70000, $ad->getCostIrr());
        $this->assertSame('[LADDER] [STANDARD] Toyota Camry 2020', $ad->render());

        // Step 2: User adds Urgent
        $ad = new UrgentBadgeDecorator($ad);
        $this->assertSame(120000, $ad->getCostIrr());
        $this->assertSame('[URGENT] [LADDER] [STANDARD] Toyota Camry 2020', $ad->render());
    }
}
