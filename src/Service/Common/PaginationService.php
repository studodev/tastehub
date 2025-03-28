<?php

namespace App\Service\Common;

use App\Model\Common\Pagination;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class PaginationService
{
    public function __construct(
        #[Autowire('%pagination%')] private array $config,
    ) {
    }

    public function paginate(QueryBuilder $queryBuilder, int $offset, ?int $limit = null): Pagination
    {
        $pagination = new Pagination();

        $pagination
            ->setQueryBuilder($queryBuilder)
            ->setOffset($offset)
            ->setLimit($limit ?? $this->config['limit'])
        ;

        $countQueryBuilder = clone $queryBuilder;
        $queryBuilder
            ->setFirstResult($offset)
            ->setMaxResults($limit ?? $this->config['limit'])
        ;

        $pagination
            ->setResults($queryBuilder->getQuery()->getResult())
            ->setTotal($this->count($countQueryBuilder))
        ;

        return $pagination;
    }

    private function count(QueryBuilder $queryBuilder): int
    {
        $paginator = new Paginator($queryBuilder);

        return $paginator->count();
    }
}
