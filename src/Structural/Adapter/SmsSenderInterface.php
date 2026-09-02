<?php

declare(strict_types=1);

namespace App\Structural\Adapter;

/**
 * Standard domain interface expected by our application (Target Interface).
 */
interface SmsSenderInterface
{
    /**
     * Sends a one-time password (OTP) verification code to the given mobile number.
     *
     * @param string $mobileNumber The recipient's phone number (e.g. 09121112233)
     * @param string $code The generated numeric or alphanumeric OTP code
     * @return bool True if successfully dispatched, false otherwise
     */
    public function sendOtp(string $mobileNumber, string $code): bool;
}
