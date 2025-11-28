<?php

namespace App\Repository\Cooking;

use App\Entity\Cooking\Recipe;
use App\Enum\Cooking\RecipeDurationRangeEnum;
use App\Enum\Cooking\RecipeSortEnum;
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

        $whereClauses = [
            $qb->expr()->eq('r.state', ':published_state'),
        ];
        $havingClauses = [];

        if ($filter) {
            if ($categories = $filter->getCategories()) {
                $whereClauses[] = $qb->expr()->in('r.category', ':categories');
                $qb->setParameter('categories', $categories);
            }

            if ($diets = $filter->getDiets()) {
                $qb->leftJoin('r.diets', 'd');
                $whereClauses[] = $qb->expr()->in('d', ':diets');
                $qb->setParameter('diets', $diets);
            }

            if ($tags = $filter->getTags()) {
                $qb->leftJoin('r.tags', 't');
                $whereClauses[] = $qb->expr()->in('t', ':tags');
                $qb->setParameter('tags', $tags);
            }

            if ($duration = $filter->getDuration()) {
                $this->addSelectTotalTime($qb);

                if (RecipeDurationRangeEnum::Short === $duration) {
                    $havingClauses[] = $qb->expr()->lt('totalTime', 30);
                } elseif (RecipeDurationRangeEnum::Medium === $duration) {
                    $havingClauses[] = $qb->expr()->lt('totalTime', 60);
                    $havingClauses[] = $qb->expr()->gte('totalTime', 30);
                } else {
                    $havingClauses[] = $qb->expr()->gte('totalTime', 60);
                }
            }

            if ($query = $filter->getQuery()) {
                $qb->join('r.author', 'a');
                $qb->join('r.recipeIngredients', 'ri');
                $qb->join('ri.ingredient', 'i');

                $whereClauses[] = $qb->expr()->orX(
                    $qb->expr()->like('r.title', ':query'),
                    $qb->expr()->like('r.description', ':query'),
                    $qb->expr()->like('a.username', ':query'),
                    $qb->expr()->like('i.label', ':query'),
                );

                $qb->setParameter('query', '%' . $query . '%');
            }
        }

        // TODO - Add rating order
        $sort = match ($filter?->getSort()) {
            RecipeSortEnum::Alpha => ['r.title', 'ASC'],
            RecipeSortEnum::Rating => ['r.title', 'DESC'],
            default => ['r.createdAt', 'DESC'],
        };

        $qb
            ->where($qb->expr()->andX(...$whereClauses))
            ->setParameter('published_state', RecipeStateEnum::Published->value)
            ->orderBy($sort[0], $sort[1])
        ;

        if ($havingClauses) {
            $qb->having($qb->expr()->andX(...$havingClauses));
        }

        return $qb;
    }

    private function addSelectTotalTime(QueryBuilder $qb): void
    {
        $qb->addSelect('IFNULL(JSON_VALUE(r.timer, \'$.preparationTime\'), 0) + IFNULL(JSON_VALUE(r.timer, \'$.waitingTime\'), 0) + IFNULL(JSON_VALUE(r.timer, \'$.cookingTime\'), 0) AS HIDDEN totalTime');
    }
}
