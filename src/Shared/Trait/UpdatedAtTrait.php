<?php

namespace App\Shared\Trait;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait UpdatedAtTrait
{
    #[ORM\Column(nullable: true)]
    private ?DateTime $updatedAt = null;

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function autoUpdatedAt(): void
    {
        $this->updatedAt = new DateTime();
    }
}
