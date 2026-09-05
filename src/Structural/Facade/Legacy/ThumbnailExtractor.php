<?php

declare(strict_types=1);

namespace App\Structural\Facade\Legacy;

final class ThumbnailExtractor
{
    public function extractCover(string $filePath, int $seekSeconds = 3): string
    {
        // Low-level keyframe grabber exporting poster image
        return "/storage/thumbnails/{$filePath}_seek_{$seekSeconds}s_poster.jpg";
    }
}
