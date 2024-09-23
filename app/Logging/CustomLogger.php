<?php
namespace App\Logging;

class CustomLogger
{
    public function log($message)
    {
        // Customize your logging mechanism
        \Log::info($message);
    }
}
