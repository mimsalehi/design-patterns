<?php

declare(strict_types=1);

namespace App\Structural\Composite\Legacy;

final class MediaCollection
{
    /** @var MovieItem[] */
    private array $standaloneMovies = [];

    /** @var SeriesSeason[] */
    private array $seasons = [];

    /** @var MediaCollection[] */
    private array $subCollections = [];

    public function __construct(
        private string $collectionName
    ) {}

    public function addMovie(MovieItem $movie): void
    {
        $this->standaloneMovies[] = $movie;
    }

    public function addSeason(SeriesSeason $season): void
    {
        $this->seasons[] = $season;
    }

    public function addSubCollection(self $collection): void
    {
        $this->subCollections[] = $collection;
    }

    /**
     * @return MovieItem[]
     */
    public function getStandaloneMovies(): array
    {
        return $this->standaloneMovies;
    }

    /**
     * @return SeriesSeason[]
     */
    public function getSeasons(): array
    {
        return $this->seasons;
    }

    /**
     * @return MediaCollection[]
     */
    public function getSubCollections(): array
    {
        return $this->subCollections;
    }

    public function getCollectionName(): string
    {
        return $this->collectionName;
    }
}
