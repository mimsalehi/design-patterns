<?php

declare(strict_types=1);

namespace App\Structural\Facade\Subsystems;

class ThumbnailExtractor
{
    public function extractCover(string $filePath, int $seekSeconds = 3): string
    {
        return "/storage/thumbnails/{$filePath}_seek_{$seekSeconds}s_poster.jpg";
    }
}
