<?php

declare(strict_types=1);

use App\Structural\Facade\Legacy\AudioNormalizer as LegacyAudioNormalizer;
use App\Structural\Facade\Legacy\CdnStoragePublisher as LegacyCdnStoragePublisher;
use App\Structural\Facade\Legacy\ThumbnailExtractor as LegacyThumbnailExtractor;
use App\Structural\Facade\Legacy\VideoTranscoder as LegacyVideoTranscoder;
use App\Structural\Facade\Legacy\VideoValidator as LegacyVideoValidator;
use App\Structural\Facade\Legacy\WatermarkProcessor as LegacyWatermarkProcessor;
use App\Structural\Facade\AparatVideoPublishingFacade;

// ============================================================================
// 0. Legacy Approach: Tightly Coupled Subsystem Orchestration in Controller
// ============================================================================
echo "=== 0. Legacy Approach: Manual Subsystem Orchestration in Client ===\n";
echo "Notice: Client must instantiate, configure, and coordinate 6 low-level subsystems!\n\n";

$legacyRawFile = 'dota2_esports_championship.mov';
$legacyChannelName = 'iran_cyber_games';

// Step 1: Validate file format & integrity
$validator = new LegacyVideoValidator();
if (!$validator->validate($legacyRawFile)) {
    throw new RuntimeException("Invalid video format.");
}
$bitrate = $validator->checkBitrate($legacyRawFile);
echo "1. Validated video format. Source bitrate: {$bitrate} kbps\n";

// Step 2: Normalize audio track loudness to EBU R128 standard (-14 LUFS)
$normalizer = new LegacyAudioNormalizer();
$normalizedFile = $normalizer->normalizeLoudness($legacyRawFile, -14);
echo "2. Audio track normalized: {$normalizedFile}\n";

// Step 3: Burn channel watermark on bottom-right corner
$watermark = new LegacyWatermarkProcessor();
$watermarkedFile = $watermark->applyChannelWatermark($normalizedFile, $legacyChannelName, 'bottom-right');
echo "3. Channel watermark applied: {$watermarkedFile}\n";

// Step 4: Multi-rendition HLS Transcoding
$transcoder = new LegacyVideoTranscoder();
$manifestPath = $transcoder->transcodeHls($watermarkedFile, ['1080p', '720p', '480p']);
echo "4. Transcoded HLS manifest: {$manifestPath}\n";

// Step 5: Extract poster thumbnail
$thumbnailExtractor = new LegacyThumbnailExtractor();
$posterPath = $thumbnailExtractor->extractCover($legacyRawFile, 3);
echo "5. Thumbnail extracted: {$posterPath}\n";

// Step 6: Upload and publish to ArvanCloud CDN
$cdnPublisher = new LegacyCdnStoragePublisher();
$streamUrl = $cdnPublisher->publishToArvanCloud($manifestPath, $posterPath);
echo "6. Published to CDN: {$streamUrl}\n\n";

echo "Publishing Summary (Legacy):\n";
echo "  Stream URL: {$streamUrl}\n";
echo "  Poster Cover: {$posterPath}\n\n";

// ============================================================================
// 1. Refactored Facade Approach: 1-Line Clean Publishing via Facade
// ============================================================================
echo "=== 1. Refactored Facade Pattern Approach (Clean 1-Line Client Call) ===\n";
echo "Notice: Client calls a single high-level publish() method; zero coupling to subsystems!\n\n";

$aparat = new AparatVideoPublishingFacade();

$publishedVideo = $aparat->publish(
    filePath: 'pes_2025_tehran_derby.mp4',
    channelName: 'persian_gamers_hub',
    resolutions: ['1080p', '720p', '480p', '360p']
);

echo "Video Published Successfully via Facade:\n";
echo "  Title: " . $publishedVideo->title . "\n";
echo "  Channel: " . $publishedVideo->channelName . "\n";
echo "  Stream HLS URL: " . $publishedVideo->streamUrl . "\n";
echo "  Poster Cover URL: " . $publishedVideo->posterUrl . "\n";
echo "  Available Renditions: " . implode(', ', $publishedVideo->resolutions) . "\n";
echo "  Source Bitrate: " . number_format($publishedVideo->bitrateKbps) . " kbps\n";
