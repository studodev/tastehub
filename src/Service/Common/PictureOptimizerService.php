<?php

namespace App\Service\Common;

use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageManagerInterface;

final readonly class PictureOptimizerService
{
    private ImageManagerInterface $manager;

    public function __construct()
    {
        $this->manager = ImageManager::usingDriver(Driver::class);
    }

    public function limitSize(string $filePath, int $size): void
    {
        $image = $this->manager->decode($filePath);

        if ($image->width() > $image->height()) {
            $image->scaleDown(height: $size);
        } else {
            $image->scaleDown(width: $size);
        }

        $image->save(path: $filePath, quality: 80);
    }
}
