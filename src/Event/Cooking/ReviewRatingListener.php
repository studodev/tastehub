<?php

namespace App\Event\Cooking;

use App\Entity\Cooking\Review;
use App\Repository\Cooking\ReviewRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::postPersist, method: 'updateAverageRating', entity: Review::class)]
#[AsEntityListener(event: Events::postUpdate, method: 'updateAverageRating', entity: Review::class)]
#[AsEntityListener(event: Events::postRemove, method: 'updateAverageRating', entity: Review::class)]
final readonly class ReviewRatingListener
{
    public function __construct(
        private EntityManagerInterface $em,
        private ReviewRepository $reviewRepository,
    ) {
    }

    public function updateAverageRating(Review $review): void
    {
        $recipe = $review->getRecipe();
        $averageRating = $this->reviewRepository->calculateAverageRating($recipe);
        $recipe->setAverageRating($averageRating);
        $this->em->flush();
    }
}
