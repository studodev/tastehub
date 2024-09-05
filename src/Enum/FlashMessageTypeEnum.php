<?php

namespace App\Enum;

enum FlashMessageTypeEnum: string
{
    case NOTICE = 'notice';
    case ERROR = 'error';
}
