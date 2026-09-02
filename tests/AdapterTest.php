<?php

declare(strict_types=1);

namespace App\Tests;

use App\Structural\Adapter\KavenegarSmsAdapter;
use App\Structural\Adapter\SmsSenderInterface;
use App\Structural\Adapter\ThirdParty\KavenegarApi;
use App\Structural\Adapter\UserAuthController;
use PHPUnit\Framework\TestCase;

class AdapterTest extends TestCase
{
    public function testKavenegarAdapterTranslatesSuccessfulResponseToTrue(): void
    {
        // 1. Mock KavenegarApi (Adaptee)
        $kavenegarMock = $this->createMock(KavenegarApi::class);
        $kavenegarMock->expects($this->once())
            ->method('VerifyLookup')
            ->with(
                '09121112233',
                '12345',
                null,
                null,
                'otp-login'
            )
            ->willReturn([
                'entries' => [
                    [
                        'status' => 200,
                        'messageid' => 99481,
                    ],
                ],
            ]);

        // 2. Wrap in adapter
        $adapter = new KavenegarSmsAdapter($kavenegarMock, 'otp-login');

        // 3. Assert target interface contract
        $this->assertInstanceOf(SmsSenderInterface::class, $adapter);
        $this->assertTrue($adapter->sendOtp('09121112233', '12345'));
    }

    public function testKavenegarAdapterHandlesFailedResponseAsFalse(): void
    {
        $kavenegarMock = $this->createMock(KavenegarApi::class);
        $kavenegarMock->expects($this->once())
            ->method('VerifyLookup')
            ->willReturn([
                'entries' => [
                    [
                        'status' => 411, // Invalid token or insufficient credit
                    ],
                ],
            ]);

        $adapter = new KavenegarSmsAdapter($kavenegarMock, 'otp-login');
        $this->assertFalse($adapter->sendOtp('09121112233', '12345'));
    }
    public function testFarazAdapterTranslatesSuccessfulResponseToTrue(): void
    {
        $farazMock = $this->createMock(\App\Structural\Adapter\ThirdParty\FarazApi::class);
        $farazMock->expects($this->once())
            ->method('VerifyLookup')
            ->with('09121112233', '54321', null, null, 'otp-login')
            ->willReturn([
                'result' => [
                    [
                        'status' => 200,
                    ],
                ],
            ]);

        $adapter = new \App\Structural\Adapter\FarazSmsAdapter($farazMock, 'otp-login');
        $this->assertInstanceOf(SmsSenderInterface::class, $adapter);
        $this->assertTrue($adapter->sendOtp('09121112233', '54321'));
    }

    public function testUserAuthControllerInteractsOnlyWithInterfaceViaMock(): void
    {
        // Mock the target interface
        $smsSenderMock = $this->createMock(SmsSenderInterface::class);
        $smsSenderMock->expects($this->once())
            ->method('sendOtp')
            ->with(
                '09351234567',
                $this->callback(fn($code) => strlen((string) $code) === 5)
            )
            ->willReturn(true);

        $authController = new UserAuthController($smsSenderMock);
        $result = $authController->requestLoginOtp('09351234567');

        $this->assertTrue($result);
    }
}
