<?php

namespace App\Enum\Cooking;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum RecipeDurationRangeEnum: string implements TranslatableInterface
{
    case Short = 'short';
    case Medium = 'medium';
    case Long = 'long';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans(sprintf('cooking.recipe_duration_range.%s', $this->value), [], 'enum');
    }
}
