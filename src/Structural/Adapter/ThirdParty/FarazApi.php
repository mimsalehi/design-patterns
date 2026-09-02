<?php

declare(strict_types=1);

namespace App\Structural\Adapter\ThirdParty;

/**
 * 3rd-Party Vendor SDK provided by faraz SMS platform (Cannot be modified!).
 * This is the "Adaptee" in the Adapter design pattern.
 */
class FarazApi
{
    public function __construct(
        private string $apiKey = 'faraz_live_secret_key_88410'
    ) {
    }

    /**
     * faraz service pattern lookup method.
     * Notice the vendor-specific parameters: receptor, token, template.
     */
    public function VerifyLookup(
        string $receptor,
        string $token,
        ?string $token2,
        ?string $token3,
        string $template
    ): array {
        echo sprintf(
            "[faraz Gateway API] Dispatching OTP Token '%s' to Receptor '%s' using template '%s'...\n",
            $token,
            $receptor,
            $template
        );

        // Simulating faraz REST API JSON response
        return [
            'result' => [
                [
                    'messageid' => rand(1000000, 9999999),
                    'message' => "Your login code is {$token}",
                    'status' => 200, // 200 means delivered successfully
                    'statustext' => 'Delivered',
                    'receptor' => $receptor,
                    'cost' => 120, // IRR
                ],
            ],
        ];
    }
}
