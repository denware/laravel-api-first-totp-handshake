<?php

namespace YourName\TOTPHandshake\Services;

use OTPHP\TOTP;

class TOTPService
{
    protected static string $path = '/opt/shared/otp.key';

    /**
     * Generate a new random secret and write to shared volume.
     */
    public static function rotate(): string
    {
        $newSecret = strtoupper(bin2hex(random_bytes(10)));
        file_put_contents(static::$path, $newSecret);
        return $newSecret;
    }

    /**
     * Get the current shared secret from file.
     */
    public static function getSecret(): ?string
    {
        return is_file(static::$path)
            ? trim(file_get_contents(static::$path))
            : null;
    }

    /**
     * Verify provided code against current secret.
     */
    public static function verify(string $code): bool
    {
        $secret = static::getSecret();
        if (!$secret) {
            return false;
        }

        $totp = TOTP::create($secret, 30, 'sha1', 6);
        return $totp->verify($code, null, 1);
    }

    /**
     * Compute the current TOTP code (for demonstration or local client use).
     */
    public static function currentCode(): ?string
    {
        $secret = static::getSecret();
        if (!$secret) {
            return null;
        }

        return TOTP::create($secret, 30, 'sha1', 6)->now();
    }
}
