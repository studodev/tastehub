<?php

namespace App\Repository\Cooking;

use App\Entity\Cooking\Ingredient;
use App\Model\Common\SearchableRepositoryConfiguration;
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

    public function configureSearch(): SearchableRepositoryConfiguration
    {
        $configuration = new SearchableRepositoryConfiguration();

        $configuration
            ->setDisplayLabel('label')
            ->setSearchableFields(['label'])
            ->setExtraFields([
                'pictogram' => 't.pictogram',
            ])
            ->setJoins([
                't' => 'root.type',
            ])
        ;

        return $configuration;
    }
}
