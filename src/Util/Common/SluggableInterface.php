<?php

namespace App\Util\Common;

interface SluggableInterface
{
    public function getSlugSource(): string;

    public function setSlug(?string $slug): static;
}
