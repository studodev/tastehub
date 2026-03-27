<?php

namespace App\Security\Voter\Cooking;

use App\Entity\Cooking\Recipe;
use App\Entity\Cooking\Review;
use App\Entity\User\User;
use App\Repository\Cooking\ReviewRepository;
use Symfony\Component\Security\Core\Authentication\Token\NullToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ReviewVoter extends Voter
{
    public const string ATTRIBUTE_CREATE = 'REVIEW_CREATE';
    public const array ATTRIBUTES = [self::ATTRIBUTE_CREATE];

    public function __construct(private ReviewRepository $reviewRepository)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (self::ATTRIBUTE_CREATE === $attribute && $subject instanceof Recipe) {
            return true;
        }

        return in_array($attribute, self::ATTRIBUTES) && $subject instanceof Review;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        if ($token instanceof NullToken) {
            return false;
        }

        $user = $token->getUser();

        if ($subject instanceof Review) {
            $recipe = $subject->getRecipe();
        } else {
            $recipe = $subject;
        }

        return match ($attribute) {
            self::ATTRIBUTE_CREATE => $this->canCreate($recipe, $user),
        };
    }

    private function canCreate(Recipe $recipe, User $user): bool
    {
        if ($user === $recipe->getAuthor()) {
            return false;
        }

        $counter = $this->reviewRepository->count([
            'user' => $user,
            'recipe' => $recipe,
        ]);

        if ($counter > 0) {
            return false;
        }

        return true;
    }
}
