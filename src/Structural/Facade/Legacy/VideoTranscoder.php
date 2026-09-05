<?php

declare(strict_types=1);

namespace App\Structural\Facade\Legacy;

final class VideoTranscoder
{
    /**
     * @param string[] $resolutions
     */
    public function transcodeHls(string $filePath, array $resolutions): string
    {
        // Low-level FFmpeg multi-rendition HLS encoding producing master playlist
        $resList = implode(', ', $resolutions);
        return "/storage/hls/{$filePath}/master.m3u8 [{$resList}]";
    }
}
