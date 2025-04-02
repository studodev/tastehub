<?php

namespace App\Service\Common;

use App\Model\Common\Pagination;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class PaginationService
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
            ->setLimit($limit ?? $this->config['limit'])
        ;

        $queryBuilder
            ->setFirstResult($offset)
            ->setMaxResults($pagination->getLimit())
        ;

        $paginator = new Paginator($queryBuilder);

        $pagination
            ->setResults($paginator->getIterator()->getArrayCopy())
            ->setTotal($paginator->count())
            ->setOffset($offset + $pagination->getLimit())
        ;

        return $pagination;
    }
}
