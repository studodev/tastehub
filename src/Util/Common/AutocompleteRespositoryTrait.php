<?php

namespace App\Util\Common;

trait AutocompleteRespositoryTrait
{
    public function autocomplete(string $query): array
    {
        $configuration = $this->configureSearch();
        $stmt = $this->createQueryBuilder('root');

        $selectClauses = [
            'root.id AS value',
            sprintf('root.%s AS text', $configuration->getDisplayLabel()),
        ];

        foreach ($configuration->getExtraFields() as $alias => $field) {
            $selectClauses[] = sprintf('%s AS data:%s', $field, $alias);
        }

        $stmt->select(...$selectClauses);

        foreach ($configuration->getJoins() as $alias => $join) {
            $stmt->join($join, $alias);
        }

        $whereClauses = [];

        foreach ($configuration->getSearchableFields() as $field) {
            $whereClauses[] = $stmt->expr()->like(sprintf('root.%s', $field), ':query');
        }

        $stmt->where(
            $stmt->expr()->orX(...$whereClauses),
        );
        $stmt->setParameter('query', '%' . $query . '%');

        $stmt->setMaxResults(10);

        return $stmt->getQuery()->getResult();
    }
}
