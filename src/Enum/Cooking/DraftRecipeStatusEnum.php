<?php

namespace App\Enum\Cooking;

enum DraftRecipeStatusEnum: string
{
    case Metadata = 'Métadonnées';
    case Details = 'Détails';
    case Ingredients = 'Ingrédients';
    case Utensils = 'Ustensiles';
    case Steps = 'Étapes';
}
