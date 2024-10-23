<?php

namespace App\Enum\Cooking;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum QuantityCounterUnitEnum: string implements TranslatableInterface
{
    case Person = 'person';
    case Portion = 'portion';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans(sprintf('cooking.quantity_counter_unit.%s', $this->value), [], 'enum');
    }
}
