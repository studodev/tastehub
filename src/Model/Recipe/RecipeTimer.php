<?php

namespace App\Model\Recipe;

class RecipeTimer
{
    private ?int $preparationTime;

    private ?int $cookingTime;

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
