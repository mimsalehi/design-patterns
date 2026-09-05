<?php

declare(strict_types=1);

namespace App\Structural\Facade\Subsystems;

class CdnStoragePublisher
{
    public function publishToArvanCloud(string $manifestPath, string $posterPath): string
    {
        return "https://cdn.aparat.com/streams/live_vod_1403/master.m3u8";
    }
}
