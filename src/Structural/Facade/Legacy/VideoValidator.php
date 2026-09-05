<?php

declare(strict_types=1);

namespace App\Structural\Facade\Legacy;

final class VideoValidator
{
    public function validate(string $filePath): bool
    {
        return str_ends_with($filePath, '.mp4') || str_ends_with($filePath, '.mov');
    }

    public function checkBitrate(string $filePath): int
    {
        // Low-level check: returns bitrate in kbps
        return 8500;
    }
}
