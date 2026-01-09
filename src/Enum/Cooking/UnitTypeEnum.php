<?php

namespace App\Enum\Cooking;

use Symfony\Contracts\Translation\TranslatorInterface;

enum UnitTypeEnum: string
{
    case Mass = 'mass';
    case Volume = 'volume';
    case Count = 'count';
    case Empirical = 'empirical';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans(sprintf('cooking.unit_type.%s', $this->value), [], 'enum');
    }
}
