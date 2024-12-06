<?php

namespace App\Util\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('pictogram_url', [AssetRuntime::class, 'getPictogramUrl']),
        ];
    }
}
