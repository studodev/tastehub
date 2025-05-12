<?php

namespace App\Enum\Cooking;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum RecipeSortEnum: string implements TranslatableInterface
{
    case Alpha = 'aplha';
    case Newest = 'newest';
    case Rating = 'rating';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans(sprintf('cooking.recipe_sort.%s', $this->value), [], 'enum');
    }
}
