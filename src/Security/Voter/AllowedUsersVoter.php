<?php

namespace App\Security\Voter;

use App\Shared\Contract\AllowedUsersInterface;
use Symfony\Component\Security\Core\Authentication\Token\NullToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AllowedUsersVoter extends Voter
{
    public const string ATTRIBUTE = 'ALLOWED_USERS';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return self::ATTRIBUTE === $attribute;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        if (null === $subject) {
            return true;
        }

        if ($token instanceof NullToken) {
            return false;
        }

        if (!$subject instanceof AllowedUsersInterface) {
            return false;
        }

        return in_array($token->getUser(), $subject->allowedUsers(), true);
    }
}
