<?php

namespace App\Shared\Contract;

use App\Model\Common\SearchableRepositoryConfiguration;

interface SearchableRepositoryInterface
{
    public function configureSearch(): SearchableRepositoryConfiguration;
}
