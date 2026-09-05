<?php

declare(strict_types=1);

namespace App\Structural\Facade\Legacy;

final class AudioNormalizer
{
    public function normalizeLoudness(string $filePath, int $targetLufs = -14): string
    {
        // Low-level audio filter applying EBU R128 standard loudness
        return "normalized_{$targetLufs}lufs_{$filePath}";
    }
}
