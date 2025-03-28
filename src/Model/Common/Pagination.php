<?php

namespace App\Model\Common;

use Doctrine\ORM\QueryBuilder;

class Pagination
{
    private QueryBuilder $queryBuilder;
    private int $limit;
    private int $offset;
    private iterable $results;
    private int $total;

    public function getQueryBuilder(): QueryBuilder
    {
        return $this->queryBuilder;
    }

    public function setQueryBuilder(QueryBuilder $queryBuilder): static
    {
        $this->queryBuilder = $queryBuilder;

        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function setOffset(int $offset): static
    {
        $this->offset = $offset;

        return $this;
    }

    public function getResults(): iterable
    {
        return $this->results;
    }

    public function setResults(iterable $results): static
    {
        $this->results = $results;

        return $this;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

        return $this;
    }
}
