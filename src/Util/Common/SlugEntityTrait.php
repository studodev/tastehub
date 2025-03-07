<?php

namespace App\Util\Common;

use Doctrine\ORM\Mapping as ORM;

trait SlugEntityTrait
{
    #[ORM\Column(length: 180, unique: true)]
    private ?string $slug = null;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
