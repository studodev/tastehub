<?php

namespace App\Util\Common;

use App\Model\Common\SearchableRepositoryConfiguration;

interface SearchableRepositoryInterface
{
    public function configureSearch(): SearchableRepositoryConfiguration;
}
