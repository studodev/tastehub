<?php

namespace App\Model\Cooking;

use App\Entity\Cooking\Recipe;
use App\Enum\Cooking\DraftRecipeStatusEnum;

class DraftRecipe
{
    private ?int $recipeIdentifier = null;

    private ?Recipe $recipe;

    private ?DraftRecipeStatusEnum $status = DraftRecipeStatusEnum::Metadata;

    private array $savedStates = [];

    public function __construct()
    {
        $this->recipe = new Recipe();
    }

    public function getRecipeIdentifier(): ?int
    {
        return $this->recipeIdentifier;
    }

    public function setRecipeIdentifier(?int $recipeIdentifier): static
    {
        $this->recipeIdentifier = $recipeIdentifier;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getStatus(): ?DraftRecipeStatusEnum
    {
        return $this->status;
    }

    public function setStatus(?DraftRecipeStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getSavedState(DraftRecipeStatusEnum $draftRecipeStatusEnum): ?array
    {
        return $this->savedStates[$draftRecipeStatusEnum->value] ?? null;
    }

    public function setSavedState(DraftRecipeStatusEnum $draftRecipeStatusEnum, array $data): static
    {
        $this->savedStates[$draftRecipeStatusEnum->value] = $data;

        return $this;
    }

    public function removeSavedState(DraftRecipeStatusEnum $draftRecipeStatusEnum): static
    {
        unset($this->savedStates[$draftRecipeStatusEnum->value]);

        return $this;
    }
}
