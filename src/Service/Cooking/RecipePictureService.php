<?php

namespace App\Service\Cooking;

use App\Entity\Cooking\Recipe;
use App\Enum\Common\FileManagerBucketEnum;
use App\Service\Common\FileManagerService;

readonly class RecipePictureService
{
    public function __construct(private FileManagerService $fileManager)
    {
    }

    // TODO - Resize and optimize images
    public function upload(Recipe $recipe): void
    {
        if (null === $recipe->getPictureFile()) {
            return;
        }

        $filename = $this->fileManager->upload($recipe->getPictureFile(), FileManagerBucketEnum::Recipe);

        if (null !== $recipe->getPicture()) {
            $this->fileManager->remove($recipe->getPicture(), FileManagerBucketEnum::Recipe);
        }

        $recipe->setPicture($filename);
    }
}
