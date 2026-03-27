<?php

namespace App\Model\Cooking;

use App\Enum\Cooking\ReviewSortEnum;

class ReviewFilter
{
    private ReviewSortEnum $sort = ReviewSortEnum::Newest;

    public function getSort(): ReviewSortEnum
    {
        return $this->sort;
    }

    public function setSort(ReviewSortEnum $sort): static
    {
        $this->sort = $sort;

        return $this;
    }
}
