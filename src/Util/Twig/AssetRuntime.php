<?php

namespace App\Util\Twig;

use App\Enum\Common\PictogramTypeEnum;
use App\Service\Common\PictogramService;
use Twig\Extension\RuntimeExtensionInterface;

readonly class AssetRuntime implements RuntimeExtensionInterface
{
    public function __construct(private PictogramService $pictogramService)
    {
    }

    public function getPictogramUrl(PictogramTypeEnum $type, string $name): string
    {
        return $this->pictogramService->buildUrl($type, $name);
    }
}
