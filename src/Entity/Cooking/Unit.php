<?php

namespace App\Entity\Cooking;

use App\Enum\Cooking\UnitTypeEnum;
use App\Repository\Cooking\UnitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnitRepository::class)]
class Unit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $symbol = null;

    #[ORM\Column(length: 50)]
    private ?string $label = null;

    #[ORM\Column(length: 20)]
    private ?UnitTypeEnum $type = null;

    #[ORM\Column(nullable: true)]
    private ?float $baseFactor = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    private ?self $baseUnit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): static
    {
        $this->symbol = $symbol;

        return $this;
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

    public function getType(): ?UnitTypeEnum
    {
        return $this->type;
    }

    public function setType(?UnitTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getBaseFactor(): ?float
    {
        return $this->baseFactor;
    }

    public function setBaseFactor(?float $baseFactor): static
    {
        $this->baseFactor = $baseFactor;

        return $this;
    }

    public function getBaseUnit(): ?self
    {
        return $this->baseUnit;
    }

    public function setBaseUnit(?self $baseUnit): static
    {
        $this->baseUnit = $baseUnit;

        return $this;
    }

    public function getDisplayName(): string
    {
        return sprintf('%s (%s)', $this->getLabel(), $this->getSymbol());
    }
}
