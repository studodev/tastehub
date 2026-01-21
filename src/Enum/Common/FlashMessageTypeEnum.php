<?php

namespace App\Enum\Common;

enum FlashMessageTypeEnum: string
{
    case Notice = 'notice';
    case Error = 'error';
}
