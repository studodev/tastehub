<?php

namespace App\Twig;

use App\Util\Common\TimeUtil;
use Twig\Attribute\AsTwigFilter;
use Twig\Extension\RuntimeExtensionInterface;

class TimeRuntime implements RuntimeExtensionInterface
{
    #[AsTwigFilter(name: 'format_duration')]
    public function formatDuration(?int $duration): string
    {
        if (null === $duration) {
            $duration = 0;
        }

        return TimeUtil::formatDuration($duration);
    }
}
