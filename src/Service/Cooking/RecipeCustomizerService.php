<?php

namespace App\Service\Cooking;

use App\Entity\Cooking\Recipe;
use App\Entity\Cooking\RecipeIngredient;
use App\Enum\Cooking\UnitTypeEnum;

final readonly class RecipeCustomizerService
{
    public function customizeCounter(Recipe $recipe, int $counter): void
    {
        foreach ($recipe->getRecipeIngredients() as $recipeIngredient) {
            $this->updateRecipeIngredientQuantity($recipeIngredient, $recipe->getQuantityCounter()->getValue(), $counter);
        }
    }

    private function updateRecipeIngredientQuantity(RecipeIngredient $recipeIngredient, int $initialCounter, int $targetCounter): void
    {
        if (UnitTypeEnum::Empirical === $recipeIngredient->getUnit()->getType()) {
            return;
        }

        $quantity = $recipeIngredient->getQuantity();
        $quantity = round($quantity * $targetCounter / $initialCounter, 2);
        $recipeIngredient->setCustomQuantity($quantity);
    }
}
