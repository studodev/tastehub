<?php

namespace App\Repository\Cooking;

use App\Entity\Cooking\StepRecipeIngredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StepRecipeIngredient>
 */
class StepRecipeIngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StepRecipeIngredient::class);
    }
}
