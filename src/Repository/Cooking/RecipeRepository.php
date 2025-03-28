<?php

namespace App\Repository\Cooking;

use App\Entity\Cooking\Recipe;
use App\Enum\Cooking\RecipeStateEnum;
use App\Model\Cooking\RecipeFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function findByFilterQueryBuilder(?RecipeFilter $filter = null): QueryBuilder
    {
        $qb = $this->createQueryBuilder('r');

        $qb
            ->where($qb->expr()->eq('r.state', ':published_state'))
            ->setParameter('published_state', RecipeStateEnum::Published->value)
        ;

        return $qb;
    }
}
