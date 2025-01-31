<?php

namespace App\Model\Common;

class SearchableRepositoryConfiguration
{
    private string $displayLabel = '';

    private array $searchableFields = [];

    private array $extraFields = [];

    private array $joins = [];

    public function getDisplayLabel(): string
    {
        return $this->displayLabel;
    }

    public function setDisplayLabel(string $displayLabel): static
    {
        $this->displayLabel = $displayLabel;

        return $this;
    }

    public function getSearchableFields(): array
    {
        return $this->searchableFields;
    }

    public function setSearchableFields(array $searchableFields): static
    {
        $this->searchableFields = $searchableFields;

        return $this;
    }

    public function getExtraFields(): array
    {
        return $this->extraFields;
    }

    public function setExtraFields(array $extraFields): static
    {
        $this->extraFields = $extraFields;

        return $this;
    }

    public function getJoins(): array
    {
        return $this->joins;
    }

    public function setJoins(array $joins): static
    {
        $this->joins = $joins;

        return $this;
    }
}
