<?php

namespace App\Enum\Cooking;

enum RecipeSortEnum: string
{
    case Alpha = 'aplha';
    case Newest = 'newest';
    case Rating = 'rating';
}
