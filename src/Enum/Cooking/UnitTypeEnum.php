<?php

namespace App\Enum\Cooking;

enum UnitTypeEnum: string
{
    case Mass = 'mass';
    case Volume = 'volume';
    case Count = 'count';
    case Empirical = 'empirical';
}
