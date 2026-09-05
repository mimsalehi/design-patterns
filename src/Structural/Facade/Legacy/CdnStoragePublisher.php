<?php

declare(strict_types=1);

namespace App\Structural\Facade\Legacy;

final class CdnStoragePublisher
{
    public function publishToArvanCloud(string $manifestPath, string $posterPath): string
    {
        // Low-level S3 sync to ArvanCloud Object Storage returning public HLS stream URL
        return "https://cdn.aparat.com/streams/live_vod_1403/master.m3u8";
    }
}
