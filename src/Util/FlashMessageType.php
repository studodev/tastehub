<?php

namespace App\Util;

enum FlashMessageType: string
{
    case Notice = 'notice';
    case Error = 'error';
}
