<?php

namespace App\Util\Twig;

use App\Util\Common\TimeUtil;
use Twig\Extension\RuntimeExtensionInterface;

class TimeRuntime implements RuntimeExtensionInterface
{
    public function formatDuration(int $duration): string
    {
        return TimeUtil::formatDuration($duration);
    }
}
