<?php

declare(strict_types=1);

namespace App\Tests;

use App\Structural\Composite\CatalogItemInterface;
use App\Structural\Composite\MediaCollection;
use App\Structural\Composite\MovieItem;
use PHPUnit\Framework\TestCase;

class CompositeTest extends TestCase
{
    public function testSingleMovieItemReturnsItsDuration(): void
    {
        $movie = new MovieItem('The Salesman', 125);

        $this->assertInstanceOf(CatalogItemInterface::class, $movie);
        $this->assertSame('The Salesman', $movie->getTitle());
        $this->assertSame(125, $movie->getDurationMinutes());
    }

    public function testMediaCollectionSumsDirectChildrenDuration(): void
    {
        $season = new MediaCollection('Zakhm-e Kari: Season 1');
        $season->add(new MovieItem('Episode 1', 58));
        $season->add(new MovieItem('Episode 2', 55));
        $season->add(new MovieItem('Episode 3', 62));

        $this->assertInstanceOf(CatalogItemInterface::class, $season);
        $this->assertSame('Zakhm-e Kari: Season 1', $season->getTitle());
        $this->assertCount(3, $season->getItems());
        $this->assertSame(175, $season->getDurationMinutes());
    }

    public function testNestedMediaCollectionsRecursivelyCalculateDuration(): void
    {
        // 1. Standalone Movies
        $salesman = new MovieItem('The Salesman', 125);
        $separation = new MovieItem('A Separation', 123);

        // 2. Series Season (Composite)
        $season = new MediaCollection('Zakhm-e Kari: Season 1');
        $season->add(new MovieItem('Episode 1', 58));
        $season->add(new MovieItem('Episode 2', 55));
        $season->add(new MovieItem('Episode 3', 62)); // Season total: 175

        // 3. Master Collection (Nested Composite)
        $package = new MediaCollection('Filimo Premium Drama Package');
        $package->add($salesman);
        $package->add($separation);
        $package->add($season);

        // 125 + 123 + 175 = 423
        $this->assertSame(423, $package->getDurationMinutes());
    }

    public function testRemoveItemFromMediaCollection(): void
    {
        $collection = new MediaCollection('Bonus Clips');
        $clip1 = new MovieItem('Behind The Scenes', 20);
        $clip2 = new MovieItem('Director Interview', 30);

        $collection->add($clip1);
        $collection->add($clip2);
        $this->assertSame(50, $collection->getDurationMinutes());

        $collection->remove($clip1);
        $this->assertCount(1, $collection->getItems());
        $this->assertSame(30, $collection->getDurationMinutes());
    }

    public function testPolymorphicClientTreatmentForLeafAndComposite(): void
    {
        $leaf = new MovieItem('Short Film', 15);
        $composite = new MediaCollection('Mini Series');
        $composite->add(new MovieItem('Part 1', 25));
        $composite->add(new MovieItem('Part 2', 25));

        $calculator = static fn(CatalogItemInterface $item): int => $item->getDurationMinutes();

        $this->assertSame(15, $calculator($leaf));
        $this->assertSame(50, $calculator($composite));
    }
}
