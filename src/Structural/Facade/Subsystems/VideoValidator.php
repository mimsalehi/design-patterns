<?php

declare(strict_types=1);

namespace App\Structural\Facade\Subsystems;

class VideoValidator
{
    public function validate(string $filePath): bool
    {
        return str_ends_with($filePath, '.mp4') || str_ends_with($filePath, '.mov');
    }

    public function checkBitrate(string $filePath): int
    {
        return 8500;
    }
}
