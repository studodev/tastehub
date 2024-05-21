<?php

namespace App\Util;

class SecurityUtil
{
    public static function generateToken($length = 32): string
    {
        return bin2hex(random_bytes($length));
    }
}
