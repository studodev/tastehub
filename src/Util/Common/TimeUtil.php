<?php

namespace App\Util\Common;

class TimeUtil
{
    public static function formatDuration(int $duration): string
    {
        if ($duration > 60) {
            $hours = intdiv($duration, 60);
            $minutes = $duration % 60;

            return sprintf('%dh%02d', $hours, $minutes);
        }

        return sprintf('%d min', $duration);
    }
}
