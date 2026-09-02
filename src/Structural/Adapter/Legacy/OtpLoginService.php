<?php

declare(strict_types=1);

namespace App\Structural\Adapter\Legacy;

use App\Structural\Adapter\ThirdParty\KavenegarApi;

/**
 * Legacy anti-pattern service: Directly coupled to KavenegarApi.
 */
class OtpLoginService
{
    private KavenegarApi $kavenegar;

    public function __construct()
    {
        // Tightly coupled instantiation of 3rd-party vendor
        $this->kavenegar = new KavenegarApi();
    }

    public function loginWithMobile(string $mobileNumber): bool
    {
        $otpCode = (string) rand(10000, 99999);

        echo sprintf("--- [Legacy] Direct coupling to Kavenegar for user: [%s] ---\n", $mobileNumber);

        // Hack: Domain polluted with vendor parameter names and nulls
        $rawResponse = $this->kavenegar->VerifyLookup(
            $mobileNumber,
            $otpCode,
            null,
            null,
            'login-verify'
        );

        // Hack: Manual array parsing in business code
        if (isset($rawResponse['entries'][0]['status']) && $rawResponse['entries'][0]['status'] === 200) {
            echo sprintf("[Legacy] Code [%s] sent via hardcoded Kavenegar.\n\n", $otpCode);
            return true;
        }

        echo "[Legacy] Failed to send SMS.\n\n";
        return false;
    }
}
