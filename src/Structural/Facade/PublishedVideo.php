<?php

declare(strict_types=1);

namespace App\Structural\Facade;

final readonly class PublishedVideo
{
    /**
     * @param string[] $resolutions
     */
    public function __construct(
        public string $title,
        public string $channelName,
        public string $streamUrl,
        public string $posterUrl,
        public array $resolutions,
        public int $bitrateKbps
    ) {}
}
