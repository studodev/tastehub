<?php

namespace App\Enum\Common;

enum FlashMessageTypeEnum: string
{
    case NOTICE = 'notice';
    case ERROR = 'error';
}
