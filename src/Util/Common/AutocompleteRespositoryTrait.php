<?php

namespace App\Util\Common;

trait AutocompleteRespositoryTrait
{
    public function autocomplete(string $query): array
    {
        $stmt = $this->createQueryBuilder('t');

        $textField = sprintf('t.%s AS text', $this->displayField());
        $stmt->select('t.id AS value', $textField);

        $clauses = [];
        foreach ($this->searchableFields() as $field) {
            $clauses[] = $stmt->expr()->like(sprintf('t.%s', $field), ':query');
        }

        $stmt->where(
            $stmt->expr()->orX(...$clauses),
        );
        $stmt->setParameter('query', '%' . $query . '%');

        $stmt->setMaxResults(10);

        return $stmt->getQuery()->getResult();
    }
}
