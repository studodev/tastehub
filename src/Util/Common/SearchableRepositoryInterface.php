<?php

namespace App\Util\Common;

interface SearchableRepositoryInterface
{
    public function displayField(): string;

    public function searchableFields(): array;
}
