<?php

namespace App\Util\Common;

class TimeUtil
{
    public static function formatDuration(int $duration): string
    {
        if ($duration > 60) {
            $hours = intdiv($duration, 60);
            $minutes = $duration % 60;

            return sprintf('%sh%s', $hours, $minutes);
        }

        return sprintf('%s min', $duration);
    }
}
