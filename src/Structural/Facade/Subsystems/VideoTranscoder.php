<?php

declare(strict_types=1);

namespace App\Structural\Facade\Subsystems;

class VideoTranscoder
{
    /**
     * @param string[] $resolutions
     */
    public function transcodeHls(string $filePath, array $resolutions): string
    {
        $resList = implode(', ', $resolutions);
        return "/storage/hls/{$filePath}/master.m3u8 [{$resList}]";
    }
}
