<?php

namespace App\Service\Common;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;

final readonly class JsonDataLoader
{
    public function __construct(
        private Filesystem $filesystem,
        #[Autowire('%data_loader%')] private array $config,
    ) {
    }

    public function load(string $filename): array
    {
        $path = $this->buildPath($filename);

        return json_decode($this->filesystem->readFile($path), true);
    }

    private function buildPath(string $filename): string
    {
        return sprintf('%s%s.json', $this->config['directory'], $filename);
    }
}
