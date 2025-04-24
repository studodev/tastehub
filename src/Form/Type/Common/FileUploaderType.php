<?php

namespace App\Form\Type\Common;

use App\Enum\Common\FileManagerBucketEnum;
use App\Service\Common\FileManagerService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileUploaderType extends AbstractType
{
    const IMAGE_PREVIEW_TYPE = 'image';
    const FILE_PREVIEW_TYPE = 'file';

    public function __construct(private readonly FileManagerService $fileManager)
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('current_file', null);
        $resolver->setAllowedTypes('current_file', ['null', 'array']);

        $resolver->setNormalizer('current_file', function (Options $options, $value) {
            if (null === $value) {
                return null;
            }

            $subResolver = new OptionsResolver();

            $subResolver->setRequired(['type', 'bucket', 'filename']);
            $subResolver->setAllowedValues('type', [self::IMAGE_PREVIEW_TYPE, self::FILE_PREVIEW_TYPE]);
            $subResolver->setAllowedTypes('bucket', FileManagerBucketEnum::class);
            $subResolver->setAllowedTypes('filename', ['null', 'string']);

            return $subResolver->resolve($value);
        });
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);

        if (null !== $options['current_file'] && null !== $options['current_file']['filename']) {
            $currentFile = $options['current_file'];
            $attr = [];

            if (self::IMAGE_PREVIEW_TYPE === $currentFile['type']) {
                $path = $this->fileManager->getUrl($currentFile['filename'], $currentFile['bucket']);
            } else {
                $path = $currentFile['filename'];
            }

            $attr['data-current-file'] = json_encode([
                'type' => $currentFile['type'],
                'path' => $path,
            ]);

            $view->vars['attr'] = array_merge($view->vars['attr'], $attr);
        }
    }

    public function getParent(): string
    {
        return FileType::class;
    }
}
