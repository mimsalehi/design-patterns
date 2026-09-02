<?php

declare(strict_types=1);

namespace App\Structural\Adapter;

use App\Structural\Adapter\ThirdParty\FarazApi;

/**
 * Adapter class that converts KavenegarApi into our standard SmsSenderInterface.
 */
class FarazSmsAdapter implements SmsSenderInterface
{
    public function __construct(
        private FarazApi $farazApi,
        private string $templateName = 'login-verify'
    ) {
    }

    public function sendOtp(string $mobileNumber, string $code): bool
    {
        // 1. Translate clean domain parameters into Kavenegar's vendor-specific protocol
        $response = $this->farazApi->VerifyLookup(
            receptor: $mobileNumber,
            token: $code,
            token2: null,
            token3: null,
            template: $this->templateName
        );

        // 2. Parse vendor response array and adapt to a clean boolean
        if (isset($response['result'][0]['status'])) {
            return $response['result'][0]['status'] === 200;
        }

        return false;
    }
}
