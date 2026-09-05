<?php

declare(strict_types=1);

namespace App\Structural\Facade\Subsystems;

class WatermarkProcessor
{
    public function applyChannelWatermark(string $filePath, string $channelName, string $position = 'bottom-right'): string
    {
        return "watermarked_{$channelName}_{$position}_{$filePath}";
    }
}
