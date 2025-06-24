<?php

namespace App\Helps;

use Illuminate\Support\Str;

class Service
{
    public static function createTraceId(): string
    {
        return Str::uuid()->toString();
    }
}
