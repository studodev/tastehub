<?php

namespace App\Enum\Cooking;

enum RecipeStateEnum: string
{
    case Draft = 'draft';
    case Published = 'published';
}
