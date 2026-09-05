<?php

declare(strict_types=1);

namespace App\Structural\Facade\Subsystems;

class AudioNormalizer
{
    public function normalizeLoudness(string $filePath, int $targetLufs = -14): string
    {
        return "normalized_{$targetLufs}lufs_{$filePath}";
    }
}
