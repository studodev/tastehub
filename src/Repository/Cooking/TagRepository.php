<?php

namespace App\Repository\Cooking;

use App\Entity\Cooking\Tag;
use App\Model\Common\SearchableRepositoryConfiguration;
use App\Util\Common\AutocompleteRespositoryTrait;
use App\Util\Common\SearchableRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tag>
 */
class TagRepository extends ServiceEntityRepository implements SearchableRepositoryInterface
{
    use AutocompleteRespositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function configureSearch(): SearchableRepositoryConfiguration
    {
        $configuration = new SearchableRepositoryConfiguration();

        $configuration
            ->setDisplayLabel('label')
            ->setSearchableFields(['label'])
        ;

        return $configuration;
    }
}
