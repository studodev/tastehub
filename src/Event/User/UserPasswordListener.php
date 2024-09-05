<?php

namespace App\Event\User;

use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(event: Events::prePersist, method: 'hashPassword', entity: User::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'hashPassword', entity: User::class)]
class UserPasswordListener
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
    }

    public function hashPassword(User $user): void
    {
        if (!$user->getPlainPassword()) {
            return;
        }

        $hashed = $this->hasher->hashPassword($user, $user->getPlainPassword());
        $user->setPassword($hashed);
        $user->setPlainPassword(null);
    }
}
