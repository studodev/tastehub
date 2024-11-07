<?php

namespace App\Util\Common;

interface SearchableRepositoryInterface
{
    public function displayField();
    public function searchableFields();
}
