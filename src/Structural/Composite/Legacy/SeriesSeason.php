<?php

declare(strict_types=1);

namespace App\Structural\Composite\Legacy;

final class SeriesSeason
{
    /** @var MovieItem[] */
    private array $episodes = [];

    public function __construct(
        private string $seasonTitle
    ) {}

    public function addEpisode(MovieItem $episode): void
    {
        $this->episodes[] = $episode;
    }

    /**
     * @return MovieItem[]
     */
    public function getEpisodes(): array
    {
        return $this->episodes;
    }

    public function getSeasonTitle(): string
    {
        return $this->seasonTitle;
    }
}
