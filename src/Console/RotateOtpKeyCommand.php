<?php

namespace YourName\TOTPHandshake\Console;

use Illuminate\Console\Command;
use YourName\TOTPHandshake\Services\TOTPService;

class RotateOtpKeyCommand extends Command
{
    protected $signature = 'otp:rotate';
    protected $description = 'Rotate the shared TOTP secret key (runtime generated)';

    public function handle()
    {
        $new = TOTPService::rotate();
        $this->info("New runtime TOTP secret generated: {$new}");
    }
}
