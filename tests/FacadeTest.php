<?php

declare(strict_types=1);

namespace App\Tests;

use App\Structural\Facade\AparatVideoPublishingFacade;
use App\Structural\Facade\PublishedVideo;
use App\Structural\Facade\Subsystems\AudioNormalizer;
use App\Structural\Facade\Subsystems\CdnStoragePublisher;
use App\Structural\Facade\Subsystems\ThumbnailExtractor;
use App\Structural\Facade\Subsystems\VideoTranscoder;
use App\Structural\Facade\Subsystems\VideoValidator;
use App\Structural\Facade\Subsystems\WatermarkProcessor;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FacadeTest extends TestCase
{
    public function testPublishVideoSuccessfullyWithDefaultSubsystems(): void
    {
        $facade = new AparatVideoPublishingFacade();

        $result = $facade->publish('varzesh3_football_highlights.mp4', 'varzesh3_official');

        $this->assertInstanceOf(PublishedVideo::class, $result);
        $this->assertSame('varzesh3_football_highlights.mp4', $result->title);
        $this->assertSame('varzesh3_official', $result->channelName);
        $this->assertSame('https://cdn.aparat.com/streams/live_vod_1403/master.m3u8', $result->streamUrl);
        $this->assertStringContainsString('poster.jpg', $result->posterUrl);
        $this->assertSame(['1080p', '720p', '480p'], $result->resolutions);
        $this->assertSame(8500, $result->bitrateKbps);
    }

    public function testPublishThrowsExceptionOnInvalidVideoFormat(): void
    {
        $facade = new AparatVideoPublishingFacade();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported video format: corrupted_file.exe');

        $facade->publish('corrupted_file.exe', 'test_channel');
    }

    public function testCustomResolutionsPassThroughFacade(): void
    {
        $facade = new AparatVideoPublishingFacade();

        $customResolutions = ['4K', '1440p', '1080p'];
        $result = $facade->publish('nature_documentary_iran.mov', 'iran_geography', $customResolutions);

        $this->assertSame($customResolutions, $result->resolutions);
    }

    public function testFacadeDelegatesToInjectedMockSubsystems(): void
    {
        $mockValidator = $this->createMock(VideoValidator::class);
        $mockValidator->expects($this->once())->method('validate')->with('video.mp4')->willReturn(true);
        $mockValidator->expects($this->once())->method('checkBitrate')->with('video.mp4')->willReturn(6000);

        $mockNormalizer = $this->createMock(AudioNormalizer::class);
        $mockNormalizer->expects($this->once())->method('normalizeLoudness')->with('video.mp4', -14)->willReturn('norm.mp4');

        $mockWatermark = $this->createMock(WatermarkProcessor::class);
        $mockWatermark->expects($this->once())->method('applyChannelWatermark')->with('norm.mp4', 'my_channel', 'bottom-right')->willReturn('wm.mp4');

        $mockTranscoder = $this->createMock(VideoTranscoder::class);
        $mockTranscoder->expects($this->once())->method('transcodeHls')->with('wm.mp4', ['720p'])->willReturn('master.m3u8');

        $mockThumbnail = $this->createMock(ThumbnailExtractor::class);
        $mockThumbnail->expects($this->once())->method('extractCover')->with('video.mp4', 3)->willReturn('thumb.jpg');

        $mockCdn = $this->createMock(CdnStoragePublisher::class);
        $mockCdn->expects($this->once())->method('publishToArvanCloud')->with('master.m3u8', 'thumb.jpg')->willReturn('https://mock-cdn.com/stream.m3u8');

        $facade = new AparatVideoPublishingFacade(
            $mockValidator,
            $mockNormalizer,
            $mockWatermark,
            $mockTranscoder,
            $mockThumbnail,
            $mockCdn
        );

        $result = $facade->publish('video.mp4', 'my_channel', ['720p']);

        $this->assertSame('https://mock-cdn.com/stream.m3u8', $result->streamUrl);
        $this->assertSame('thumb.jpg', $result->posterUrl);
        $this->assertSame(6000, $result->bitrateKbps);
    }
}
