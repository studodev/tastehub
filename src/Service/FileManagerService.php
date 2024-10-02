<?php

namespace App\Service;

use App\Enum\FileManagerBucketEnum;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManagerService
{
    public function __construct(
        private Filesystem $filesystem,
        #[Autowire('%file_manager%')] private array $config
    ) {
    }

    public function upload(UploadedFile $file, FileManagerBucketEnum $bucket): string
    {
        $path = $this->buildPath($bucket);
        $filename = $this->generateName($file->guessExtension());
        $file->move($path, $filename);

        return $filename;
    }

    public function remove(string $filename, FileManagerBucketEnum $bucket): void
    {
        $path = sprintf('%s%s', $this->buildPath($bucket), $filename);
        $this->filesystem->remove($path);
    }

    private function buildPath(FileManagerBucketEnum $bucket): string
    {
        return sprintf('%s%s', $this->config['directory'], $bucket->value);
    }

    private function generateName(string $extension): string {
        return sprintf('%s.%s', md5(uniqid(null, true)), $extension);
    }
}
