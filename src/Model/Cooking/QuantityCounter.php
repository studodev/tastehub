<?php

namespace App\Model\Cooking;

use App\Enum\Cooking\DraftRecipeStatusEnum;
use App\Enum\Cooking\QuantityCounterUnitEnum;
use Symfony\Component\Validator\Constraints as Assert;

class QuantityCounter
{
    public const int MIN_VALUE = 1;
    public const int MAX_VALUE = 999;

    #[Assert\NotBlank(
        message: 'Veuillez renseigner la quantité réalisée',
        groups: [DraftRecipeStatusEnum::Details->value],
    )]
    #[Assert\Range(
        notInRangeMessage: 'La quantité réalisée doit être comprise entre {{ min }} et {{ max }}',
        min: self::MIN_VALUE,
        max: self::MAX_VALUE,
        groups: [DraftRecipeStatusEnum::Details->value],
    )]
    private ?int $value = 2;

    private ?QuantityCounterUnitEnum $unit = QuantityCounterUnitEnum::Person;

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(?int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getUnit(): ?QuantityCounterUnitEnum
    {
        return $this->unit;
    }

    public function setUnit(?QuantityCounterUnitEnum $unit): static
    {
        $this->unit = $unit;

        return $this;
    }
}
