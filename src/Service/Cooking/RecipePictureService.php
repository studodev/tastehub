<?php

namespace App\Service\Cooking;

use App\Entity\Cooking\Recipe;
use App\Enum\Common\FileManagerBucketEnum;
use App\Service\Common\FileManagerService;
use App\Service\Common\PictureOptimizerService;
use Symfony\Component\Asset\PackageInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class RecipePictureService
{
    public function __construct(
        private FileManagerService $fileManager,
        private PictureOptimizerService $pictureOptimizerService,
        #[Autowire('@assets._default_package')] private PackageInterface $package,
    ) {
    }

    // TODO - Fix slug generation
    public function upload(Recipe $recipe): void
    {
        if (null === $recipe->getPictureFile()) {
            return;
        }

        $filename = $this->fileManager->upload($recipe->getPictureFile(), FileManagerBucketEnum::Recipe, $recipe->getSlug());

        $filePath = $this->fileManager->getFilePath($filename, FileManagerBucketEnum::Recipe);
        $this->pictureOptimizerService->limitSize($filePath, 500);

        $this->remove($recipe);
        $recipe->setPicture($filename);
    }

    public function remove(Recipe $recipe): void
    {
        if (null === $recipe->getPicture()) {
            return;
        }

        $this->fileManager->remove($recipe->getPicture(), FileManagerBucketEnum::Recipe);
        $recipe->setPicture(null);
    }

    public function getUrl(Recipe $recipe): string
    {
        if ($recipe->getPicture()) {
            return $this->fileManager->getUrl($recipe->getPicture(), FileManagerBucketEnum::Recipe);
        }

        return $this->package->getUrl('build/images/illustrations/default-recipe.jpg');
    }
}
