<?php

namespace App\Model\Cooking;

use App\Enum\Cooking\RecipeDurationRangeEnum;
use App\Enum\Cooking\RecipeSortEnum;

class RecipeFilter
{
    private ?string $query = null;

    private array $categories = [];

    private array $diets = [];

    private array $tags = [];

    private ?RecipeDurationRangeEnum $duration = null;

    private RecipeSortEnum $sort = RecipeSortEnum::Newest;

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function setQuery(?string $query): static
    {
        $this->query = $query;

        return $this;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    public function getDiets(): array
    {
        return $this->diets;
    }

    public function setDiets(array $diets): static
    {
        $this->diets = $diets;

        return $this;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(array $tags): static
    {
        $this->tags = $tags;

        return $this;
    }

    public function getDuration(): ?RecipeDurationRangeEnum
    {
        return $this->duration;
    }

    public function setDuration(?RecipeDurationRangeEnum $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getSort(): RecipeSortEnum
    {
        return $this->sort;
    }

    public function setSort(RecipeSortEnum $sort): static
    {
        $this->sort = $sort;

        return $this;
    }
}
