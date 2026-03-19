<?php

namespace App\Security\Voter\Cooking;

use App\Entity\Cooking\Review;
use App\Entity\User\User;
use Symfony\Component\Security\Core\Authentication\Token\NullToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ReviewVoter extends Voter
{
    public const string ATTRIBUTE_CREATE = 'REVIEW_CREATE';
    public const array ATTRIBUTES = [self::ATTRIBUTE_CREATE];

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, self::ATTRIBUTES) && $subject instanceof Review;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        if ($token instanceof NullToken) {
            return false;
        }

        $user = $token->getUser();

        return match ($attribute) {
            self::ATTRIBUTE_CREATE => $this->canCreate($subject, $user),
        };
    }

    private function canCreate(Review $review, User $user): bool
    {
        if ($user === $review->getRecipe()?->getAuthor()) {
            return false;
        }

        return true;
    }
}
