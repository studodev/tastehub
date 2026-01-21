<?php

namespace App\Shared\Contract;

interface SluggableInterface
{
    public function getSlugSource(): string;

    public function setSlug(?string $slug): static;
}
