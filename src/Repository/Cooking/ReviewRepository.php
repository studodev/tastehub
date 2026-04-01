<?php

namespace App\Repository\Cooking;

use App\Entity\Cooking\Recipe;
use App\Entity\Cooking\Review;
use App\Enum\Cooking\ReviewSortEnum;
use App\Model\Cooking\ReviewFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function findByFilterQueryBuilder(Recipe $recipe, ?ReviewFilter $filter = null): QueryBuilder
    {
        $qb = $this->createQueryBuilder('r');

        $sort = match ($filter?->getSort()) {
            ReviewSortEnum::HighestRated => ['r.rating', 'DESC'],
            ReviewSortEnum::LowestRated => ['r.rating', 'ASC'],
            default => ['r.createdAt', 'DESC'],
        };

        $qb
            ->where(
                $qb->expr()->eq('r.recipe', ':recipe')
            )
            ->setParameter('recipe', $recipe)
            ->orderBy($sort[0], $sort[1])
        ;

        return $qb;
    }

    public function calculateAverageRating(Recipe $recipe): ?float
    {
        $qb = $this->createQueryBuilder('r');

        $qb
            ->select('AVG(r.rating)')
            ->where('r.recipe = :recipe')
            ->setParameter('recipe', $recipe)
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }
}
