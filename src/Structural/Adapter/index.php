<?php

declare(strict_types=1);

use App\Structural\Adapter\FarazSmsAdapter;
use App\Structural\Adapter\KavenegarSmsAdapter;
use App\Structural\Adapter\Legacy\OtpLoginService;
use App\Structural\Adapter\ThirdParty\FarazApi;
use App\Structural\Adapter\ThirdParty\KavenegarApi;
use App\Structural\Adapter\UserAuthController;

// ============================================================================
// 0. Legacy Approach: Monolithic & Tightly Coupled
// ============================================================================
echo "=== 0. Legacy Approach (Direct Vendor Coupling) ===\n";
$legacyService = new OtpLoginService();
$legacyService->loginWithMobile('09121112233');



// ============================================================================
// 1. Adapter Pattern Approach: Decoupled & Inverted Dependency
// ============================================================================
echo "=== 1. Adapter Pattern Approach (Via KavenegarSmsAdapter) ===\n";

// A) 3rd-party vendor SDK instance (Adaptee)
$kavenegarApi = new KavenegarApi();

// B) Wrap in the adapter implementing our clean domain interface
$smsAdapter = new KavenegarSmsAdapter($kavenegarApi, templateName: 'otp-login');

// C) Client controller receives only the interface (Dependency Injection)
$authController = new UserAuthController($smsAdapter);

// D) Executing login requests
$authController->requestLoginOtp('09359998877');
$authController->requestLoginOtp('09128884455');


echo "=== 1. Adapter Pattern Approach (Via FarazSMSAdapter) ===\n";

// A) 3rd-party vendor SDK instance (Adaptee)
$farazApi = new FarazApi();

// B) Wrap in the adapter implementing our clean domain interface
$smsAdapter = new FarazSmsAdapter($farazApi, templateName: 'otp-login');

// C) Client controller receives only the interface (Dependency Injection)
$authController = new UserAuthController($smsAdapter);

// D) Executing login requests
$authController->requestLoginOtp('09359998877');
$authController->requestLoginOtp('09128884455');