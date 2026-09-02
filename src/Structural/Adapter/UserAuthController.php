<?php

declare(strict_types=1);

namespace App\Structural\Adapter;

/**
 * Domain client service responsible for handling user OTP login.
 * Notice: This class has ZERO knowledge of Kavenegar, API keys, or templates!
 */
class UserAuthController
{
    public function __construct(
        private SmsSenderInterface $smsSender
    ) {
    }

    public function requestLoginOtp(string $mobileNumber): bool
    {
        // 1. Generate 5-digit secure random OTP code
        $generatedOtp = (string) rand(10000, 99999);

        echo sprintf("--- Initiating Auth Request for user: [%s] ---\n", $mobileNumber);

        // 2. Delegate OTP dispatching via clean interface
        $isSent = $this->smsSender->sendOtp($mobileNumber, $generatedOtp);

        if ($isSent) {
            echo sprintf("Auth Success: Verification code [%s] dispatched to [%s].\n\n", $generatedOtp, $mobileNumber);
            return true;
        }

        echo sprintf("Auth Failure: Failed to dispatch verification code to [%s].\n\n", $mobileNumber);
        return false;
    }
}
