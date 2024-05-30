<?php

namespace App\Util;

enum FlashMessageTypeEnum: string
{
    case NOTICE = 'notice';
    case ERROR = 'error';
}
