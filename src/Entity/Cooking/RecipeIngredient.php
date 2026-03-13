<?php

namespace App\Entity\Cooking;

use App\Repository\Cooking\RecipeIngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipeIngredientRepository::class)]
class RecipeIngredient
{
    public const int MAX_QUANTITY = 10000;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recipeIngredients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $recipe = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ingredient $ingredient = null;

    #[Assert\When(
        expression: '!this.getUnit().getType().isEmpirical()',
        constraints: [
            new Assert\NotBlank(
                message: 'Vous devez saisir une quantité',
            ),
        ],
    )]
    #[Assert\Positive(
        message: 'Vous devez saisir une quantité positive',
    )]
    #[Assert\LessThanOrEqual(
        value: self::MAX_QUANTITY,
        message: 'La quantité ne doit pas dépasser {{ compared_value }}',
    )]
    #[ORM\Column(nullable: true)]
    private ?float $quantity = null;

    #[Assert\NotBlank(
        message: 'Vous devez choisir une unité',
    )]
    #[ORM\ManyToOne]
    private ?Unit $unit = null;

    private ?float $customQuantity = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredient $ingredient): static
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnit(): ?Unit
    {
        return $this->unit;
    }

    public function setUnit(?Unit $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getCustomQuantity(): ?float
    {
        return $this->customQuantity;
    }

    public function setCustomQuantity(?float $customQuantity): static
    {
        $this->customQuantity = $customQuantity;

        return $this;
    }

    public function getMeasure(): string
    {
        if (null === $this->getQuantity()) {
            return $this->getUnit()->getDisplaySymbol();
        }

        $quantity = $this->getCustomQuantity() ?? $this->getQuantity();

        return sprintf('%s %s', $quantity, $this->getUnit()->getDisplaySymbol($this->getQuantity() >= 2));
    }
}
