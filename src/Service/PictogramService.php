<?php

namespace App\Service;

use App\Enum\PictogramTypeEnum;
use Symfony\Component\Asset\Package;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class PictogramService
{
    public function __construct(
        #[Autowire('@assets._default_package')] private Package $package,
        #[Autowire('%pictogram%')] private array $config,
    ) {
    }

    public function buildUrl(PictogramTypeEnum $type, string $name): string
    {
        $path = sprintf('%s/%s/%s', $this->config['basePath'], $type->value, $name);
        return $this->package->getUrl($path);
    }
}
