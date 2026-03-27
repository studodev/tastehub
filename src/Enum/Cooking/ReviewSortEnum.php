<?php

namespace App\Enum\Cooking;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum ReviewSortEnum: string implements TranslatableInterface
{
    case Newest = 'newest';
    case HighestRated = 'highest_rated';
    case LowestRated = 'lowest_rated';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans(sprintf('cooking.review_sort.%s', $this->value), [], 'enum');
    }
}
