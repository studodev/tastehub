<?php

namespace App\Util\Common;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait CreatedAtTrait
{
    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function autoCreatedAt(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }
}
