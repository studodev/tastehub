<?php

namespace App\Security\Voter;

use App\Security\EntryPoint\MainEntryPoint;
use App\Security\Exception\RedirectAccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\NullToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class NotConnectedVoter extends Voter
{
    public const string ATTRIBUTE = 'NOT_CONNECTED';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return self::ATTRIBUTE === $attribute;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        if (!$token instanceof NullToken) {
            throw new RedirectAccessDeniedException(MainEntryPoint::DEFAULT_DESTINATION_ROUTE);
        }

        return true;
    }
}
