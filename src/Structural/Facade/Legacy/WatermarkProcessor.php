<?php

declare(strict_types=1);

namespace App\Structural\Facade\Legacy;

final class WatermarkProcessor
{
    public function applyChannelWatermark(string $filePath, string $channelName, string $position = 'bottom-right'): string
    {
        // Low-level FFmpeg overlay filter burning channel branding
        return "watermarked_{$channelName}_{$position}_{$filePath}";
    }
}
