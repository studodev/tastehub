<?php

namespace App\Form\Type\Common;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FileUploaderType extends AbstractType
{
    public function getParent(): string
    {
        return FileType::class;
    }
}
