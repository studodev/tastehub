<?php

namespace App\Entity\Cooking;

use App\Repository\Cooking\UtensilRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtensilRepository::class)]
class Utensil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    private ?string $pictogram = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
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
