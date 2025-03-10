<?php

namespace App\Model\Cooking;

use App\Enum\Cooking\DraftRecipeStatusEnum;
use Symfony\Component\Validator\Constraints as Assert;

class RecipeTimer
{
    #[Assert\NotBlank(
        message: 'Veuillez renseigner le temps de préparation',
        groups: [DraftRecipeStatusEnum::Details->value],
    )]
    #[Assert\Positive(
        message: 'Le temps de préparation doit être un nombre entier positif',
        groups: [DraftRecipeStatusEnum::Details->value],
    )]
    private ?int $preparationTime;

    #[Assert\PositiveOrZero(
        message: 'Le temps de cuisson doit être un nombre entier positif',
        groups: [DraftRecipeStatusEnum::Details->value],
    )]
    private ?int $cookingTime;

    #[Assert\PositiveOrZero(
        message: 'Le temps de pose doit être un nombre entier positif',
        groups: [DraftRecipeStatusEnum::Details->value],
    )]
    private ?int $waitingTime;

    public function getPreparationTime(): ?int
    {
        return $this->preparationTime;
    }

    public function setPreparationTime(?int $preparationTime): static
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    public function getCookingTime(): ?int
    {
        return $this->cookingTime;
    }

    public function setCookingTime(?int $cookingTime): static
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getWaitingTime(): ?int
    {
        return $this->waitingTime;
    }

    public function setWaitingTime(?int $waitingTime): static
    {
        $this->waitingTime = $waitingTime;

        return $this;
    }
}
