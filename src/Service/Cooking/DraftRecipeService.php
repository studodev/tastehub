<?php

namespace App\Service\Cooking;

use App\Model\Cooking\DraftRecipe;
use App\Repository\Cooking\RecipeRepository;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class DraftRecipeService
{
    public const SESSION_KEY = 'draft_recipe';

    public function __construct(
        private RecipeRepository $recipeRepository,
        private RequestStack $requestStack,
    ) {
    }

    public function retrieve(): DraftRecipe
    {
        $draft = $this->requestStack->getSession()->get(self::SESSION_KEY);

        if (!$draft instanceof DraftRecipe) {
            $draft = new DraftRecipe();
        } elseif ($draft->getRecipeIdentifier()) {
            $recipe = $this->recipeRepository->find($draft->getRecipeIdentifier());
            $draft->setRecipe($recipe);
        }

        return $draft;
    }

    public function update(DraftRecipe $draft): void
    {
        if ($recipeId = $draft->getRecipe()->getId()) {
            $draft->setRecipeIdentifier($recipeId);
        }

        $draft->setRecipe(null);
        $this->requestStack->getSession()->set(self::SESSION_KEY, $draft);
    }

    public function clear(): void
    {
        $this->requestStack->getSession()->remove(self::SESSION_KEY);
    }
}
