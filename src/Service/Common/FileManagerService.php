<?php

namespace App\Service\Common;

use App\Enum\Common\FileManagerBucketEnum;
use Symfony\Component\Asset\PackageInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class FileManagerService
{
    public function __construct(
        private Filesystem $filesystem,
        #[Autowire('@assets._default_package')] private PackageInterface $package,
        #[Autowire('%file_manager%')] private array $config,
    ) {
    }

    public function upload(UploadedFile $file, FileManagerBucketEnum $bucket, ?string $filename = null): string
    {
        $path = $this->buildPath($bucket);

        if ($filename) {
            $filename = sprintf('%s.%s', $filename, $file->guessExtension());
        } else {
            $filename = $this->generateName($file->guessExtension());
        }

        $file->move($path, $filename);

        return $filename;
    }

    public function remove(string $filename, FileManagerBucketEnum $bucket): void
    {
        $path = sprintf('%s%s', $this->buildPath($bucket), $filename);
        $this->filesystem->remove($path);
    }

    public function getUrl(string $filename, FileManagerBucketEnum $bucket): string
    {
        return $this->package->getUrl(sprintf('%s%s', $this->buildBaseUrl($bucket), $filename));
    }

    public function getFilePath(string $filename, FileManagerBucketEnum $bucket): string
    {
        return sprintf('%s%s', $this->buildPath($bucket), $filename);
    }

    private function buildBaseUrl(FileManagerBucketEnum $bucket): string
    {
        return sprintf('%s%s', $this->config['uri'], $bucket->value);
    }

    private function buildPath(FileManagerBucketEnum $bucket): string
    {
        return sprintf('%s%s', $this->config['directory'], $bucket->value);
    }

    private function generateName(string $extension): string
    {
        return sprintf('%s.%s', md5(uniqid(null, true)), $extension);
    }
}
