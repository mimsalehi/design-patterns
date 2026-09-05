<?php

declare(strict_types=1);

namespace App\Structural\Facade;

use App\Structural\Facade\Subsystems\AudioNormalizer;
use App\Structural\Facade\Subsystems\CdnStoragePublisher;
use App\Structural\Facade\Subsystems\ThumbnailExtractor;
use App\Structural\Facade\Subsystems\VideoTranscoder;
use App\Structural\Facade\Subsystems\VideoValidator;
use App\Structural\Facade\Subsystems\WatermarkProcessor;
use InvalidArgumentException;

final class AparatVideoPublishingFacade
{
    private VideoValidator $validator;
    private AudioNormalizer $audioNormalizer;
    private WatermarkProcessor $watermarkProcessor;
    private VideoTranscoder $transcoder;
    private ThumbnailExtractor $thumbnailExtractor;
    private CdnStoragePublisher $cdnPublisher;

    public function __construct(
        ?VideoValidator $validator = null,
        ?AudioNormalizer $audioNormalizer = null,
        ?WatermarkProcessor $watermarkProcessor = null,
        ?VideoTranscoder $transcoder = null,
        ?ThumbnailExtractor $thumbnailExtractor = null,
        ?CdnStoragePublisher $cdnPublisher = null
    ) {
        $this->validator = $validator ?? new VideoValidator();
        $this->audioNormalizer = $audioNormalizer ?? new AudioNormalizer();
        $this->watermarkProcessor = $watermarkProcessor ?? new WatermarkProcessor();
        $this->transcoder = $transcoder ?? new VideoTranscoder();
        $this->thumbnailExtractor = $thumbnailExtractor ?? new ThumbnailExtractor();
        $this->cdnPublisher = $cdnPublisher ?? new CdnStoragePublisher();
    }

    /**
     * High-level unified entry point for publishing a video to Aparat.
     *
     * @param string[] $resolutions
     */
    public function publish(
        string $filePath,
        string $channelName,
        array $resolutions = ['1080p', '720p', '480p']
    ): PublishedVideo {
        // 1. Validation
        if (!$this->validator->validate($filePath)) {
            throw new InvalidArgumentException("Unsupported video format: {$filePath}");
        }
        $bitrate = $this->validator->checkBitrate($filePath);

        // 2. Audio Loudness Normalization (EBU R128 standard)
        $normalizedAudio = $this->audioNormalizer->normalizeLoudness($filePath, -14);

        // 3. Watermarking
        $watermarkedFile = $this->watermarkProcessor->applyChannelWatermark(
            $normalizedAudio,
            $channelName,
            'bottom-right'
        );

        // 4. Multi-bitrate HLS Transcoding
        $manifestPath = $this->transcoder->transcodeHls($watermarkedFile, $resolutions);

        // 5. Poster Thumbnail Extraction
        $posterPath = $this->thumbnailExtractor->extractCover($filePath, 3);

        // 6. CDN Distribution Sync
        $streamUrl = $this->cdnPublisher->publishToArvanCloud($manifestPath, $posterPath);

        return new PublishedVideo(
            title: basename($filePath),
            channelName: $channelName,
            streamUrl: $streamUrl,
            posterUrl: $posterPath,
            resolutions: $resolutions,
            bitrateKbps: $bitrate
        );
    }
}
