<?php

declare(strict_types=1);

use App\Structural\Composite\Legacy\MediaCollection as LegacyCollection;
use App\Structural\Composite\Legacy\MovieItem as LegacyMovieItem;
use App\Structural\Composite\Legacy\SeriesSeason as LegacySeriesSeason;
use App\Structural\Composite\MovieItem;
use App\Structural\Composite\CatalogItemInterface;
use App\Structural\Composite\MediaCollection;

// ============================================================================
// 0. Legacy Approach: Tightly-Coupled Hierarchical Traversal with Nested Loops
// ============================================================================
echo "=== 0. Legacy Approach: Manual Tree Traversal for Filimo Catalog ===\n\n";

// Standalone Movies
$salesmanMovie = new LegacyMovieItem('The Salesman (Forushande)', 125);
$separationMovie = new LegacyMovieItem('A Separation (Jodaeiye Nader Az Simin)', 123);

// Series Episodes for 'Mortal Wound' (Zakhm-e Kari)
$ep1 = new LegacyMovieItem('Zakhm-e Kari S01E01', 58);
$ep2 = new LegacyMovieItem('Zakhm-e Kari S01E02', 55);
$ep3 = new LegacyMovieItem('Zakhm-e Kari S01E03', 62);

$season1 = new LegacySeriesSeason('Zakhm-e Kari: Season 1');
$season1->addEpisode($ep1);
$season1->addEpisode($ep2);
$season1->addEpisode($ep3);

// Master Collection: Filimo Curated Drama Package
$masterCollection = new LegacyCollection('Filimo Premium Drama Package 1403');
$masterCollection->addMovie($salesmanMovie);
$masterCollection->addMovie($separationMovie);
$masterCollection->addSeason($season1);

// Naive Recursive Calculation in Client
function calculateLegacyTotalDuration(LegacyCollection $collection): int
{
    $totalMinutes = 0;

    // 1. Traverse standalone movies
    foreach ($collection->getStandaloneMovies() as $movie) {
        $totalMinutes += $movie->getDurationMinutes();
    }

    // 2. Traverse seasons and their inner episodes
    foreach ($collection->getSeasons() as $season) {
        foreach ($season->getEpisodes() as $episode) {
            $totalMinutes += $episode->getDurationMinutes();
        }
    }

    // 3. Recursively traverse sub-collections
    foreach ($collection->getSubCollections() as $subCollection) {
        $totalMinutes += calculateLegacyTotalDuration($subCollection);
    }

    return $totalMinutes;
}

$totalMinutes = calculateLegacyTotalDuration($masterCollection);

echo "Legacy Collection Title: " . $masterCollection->getCollectionName() . "\n";
echo "Legacy Total Watch Time: {$totalMinutes} minutes (" . round($totalMinutes / 60, 1) . " hours)\n\n";

// ============================================================================
// 1. Refactored Composite Approach: Uniform Tree Handling & Zero Client Traversal
// ============================================================================
echo "=== 1. Refactored Composite Pattern Approach (Uniform Interface) ===\n\n";

// Standalone Movies (Leaves)
$salesman = new MovieItem('The Salesman (Forushande)', 125);
$separation = new MovieItem('A Separation (Jodaeiye Nader Az Simin)', 123);

// Series Season 1 (Composite Sub-branch)
$season1Collection = new MediaCollection('Zakhm-e Kari: Season 1');
$season1Collection->add(new MovieItem('Zakhm-e Kari S01E01', 58));
$season1Collection->add(new MovieItem('Zakhm-e Kari S01E02', 55));
$season1Collection->add(new MovieItem('Zakhm-e Kari S01E03', 62));

$miniSeries = new MediaCollection('Mini Series Chernobyl');
$miniSeries->add(new MovieItem('Chernobyl: S01E01', 55));
$miniSeries->add(new MovieItem('Chernobyl: S01E02', 50));

// Master Package (Master Composite holding both Leaves and another Composite)
$filimoDramaPackage = new MediaCollection('Filimo Premium Drama Package 1403');
$filimoDramaPackage->add($salesman);
$filimoDramaPackage->add($separation);
$filimoDramaPackage->add($season1Collection);
$filimoDramaPackage->add($miniSeries);

// Uniform Client Function: Treats Leaf and Composite identically
function printCatalogItemDuration(CatalogItemInterface $item): void
{
    $minutes = $item->getDurationMinutes();
    $hours = round($minutes / 60, 1);
    echo "Item: {$item->getTitle()} | Total Watch Time: {$minutes} minutes ({$hours} hours)\n";
}

// Case A: Invoking on a standalone movie (Leaf)
echo "--- Case A: Single Movie (Leaf) ---\n";
printCatalogItemDuration($salesman);

// Case B: Invoking on a series season (Composite)
echo "\n--- Case B: Series Season (Composite) ---\n";
printCatalogItemDuration($season1Collection);

// Case C: Invoking on the master package (Master Composite containing Leaves and Composites)
echo "\n--- Case C: Master Curated Package (Nested Composite) ---\n";
printCatalogItemDuration($filimoDramaPackage);
