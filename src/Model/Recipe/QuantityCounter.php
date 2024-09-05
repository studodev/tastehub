<?php

namespace App\Model\Recipe;

use App\Enum\Recipe\QuantityCounterUnitEnum;

class QuantityCounter
{
    private int $value = 2;

    private QuantityCounterUnitEnum $unit = QuantityCounterUnitEnum::Person;

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getUnit(): QuantityCounterUnitEnum
    {
        return $this->unit;
    }

    public function setUnit(QuantityCounterUnitEnum $unit): static
    {
        $this->unit = $unit;

        return $this;
    }
}
