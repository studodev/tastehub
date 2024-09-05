<?php

namespace App\Entity\Recipe;

use App\Repository\Recipe\IngredientTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientTypeRepository::class)]
class IngredientType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pictogram = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPictogram(): ?string
    {
        return $this->pictogram;
    }

    public function setPictogram(string $pictogram): static
    {
        $this->pictogram = $pictogram;

        return $this;
    }
}
