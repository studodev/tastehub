<?php

namespace App\Entity\Recipe;

use App\Repository\Recipe\StepRecipeIngredientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StepRecipeIngredientRepository::class)]
class StepRecipeIngredient
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'stepRecipeIngredients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Step $step = null;

    #[ORM\Id]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?RecipeIngredient $recipeIngredient = null;

    #[ORM\Column]
    private ?float $quantity = null;

    public function getStep(): ?Step
    {
        return $this->step;
    }

    public function setStep(?Step $step): static
    {
        $this->step = $step;

        return $this;
    }

    public function getRecipeIngredient(): ?RecipeIngredient
    {
        return $this->recipeIngredient;
    }

    public function setRecipeIngredient(?RecipeIngredient $recipeIngredient): static
    {
        $this->recipeIngredient = $recipeIngredient;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}
