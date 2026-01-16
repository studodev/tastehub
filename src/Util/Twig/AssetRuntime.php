<?php

namespace App\Util\Twig;

use App\Entity\Cooking\Recipe;
use App\Enum\Common\PictogramTypeEnum;
use App\Service\Common\PictogramService;
use App\Service\Cooking\RecipePictureService;
use Twig\Attribute\AsTwigFunction;
use Twig\Extension\RuntimeExtensionInterface;

readonly class AssetRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private RecipePictureService $recipePictureService,
        private PictogramService $pictogramService,
    ) {
    }

    #[AsTwigFunction('recipe_image_url')]
    public function getRecipeImageUrl(Recipe $recipe): string
    {
        return $this->recipePictureService->getUrl($recipe);
    }

    #[AsTwigFunction('pictogram_url')]
    public function getPictogramUrl(PictogramTypeEnum $type, string $name): string
    {
        return $this->pictogramService->buildUrl($type, $name);
    }
}
