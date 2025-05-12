<?php

namespace App\Util\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('recipe_image_url', [AssetRuntime::class, 'getRecipeImageUrl']),
            new TwigFunction('pictogram_url', [AssetRuntime::class, 'getPictogramUrl']),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('format_duration', [TimeRuntime::class, 'formatDuration']),
        ];
    }
}
