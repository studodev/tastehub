<?php

namespace App\Util\Twig;

use App\Enum\Common\FileManagerBucketEnum;
use App\Enum\Common\PictogramTypeEnum;
use App\Service\Common\FileManagerService;
use App\Service\Common\PictogramService;
use Twig\Extension\RuntimeExtensionInterface;

readonly class AssetRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private FileManagerService $fileManagerService,
        private PictogramService $pictogramService,
    ) {
    }

    public function getFileUrl(string $filename, FileManagerBucketEnum $bucket): string
    {
        return $this->fileManagerService->getUrl($filename, $bucket);
    }

    public function getPictogramUrl(PictogramTypeEnum $type, string $name): string
    {
        return $this->pictogramService->buildUrl($type, $name);
    }
}
