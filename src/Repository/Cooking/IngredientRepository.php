<?php

namespace App\Repository\Cooking;

use App\Entity\Cooking\Ingredient;
use App\Util\Common\AutocompleteRespositoryTrait;
use App\Util\Common\SearchableRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ingredient>
 */
class IngredientRepository extends ServiceEntityRepository implements SearchableRepositoryInterface
{
    use AutocompleteRespositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ingredient::class);
    }

    public function displayField(): string
    {
        return 'label';
    }

    public function searchableFields(): array
    {
        return ['label'];
    }
}
