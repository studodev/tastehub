<?php

namespace App\Util\Twig;

use App\Entity\Cooking\Recipe;
use App\Enum\Common\PictogramTypeEnum;
use App\Service\Common\PictogramService;
use App\Service\Cooking\RecipePictureService;
use Twig\Extension\RuntimeExtensionInterface;

readonly class AssetRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private RecipePictureService $recipePictureService,
        private PictogramService $pictogramService,
    ) {
    }

    public function getRecipeImageUrl(Recipe $recipe): string
    {
        return $this->recipePictureService->getUrl($recipe);
    }

    public function getPictogramUrl(PictogramTypeEnum $type, string $name): string
    {
        return $this->pictogramService->buildUrl($type, $name);
    }
}
