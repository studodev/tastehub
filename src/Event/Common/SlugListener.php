<?php

namespace App\Event\Common;

use App\Shared\Contract\SluggableInterface;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsDoctrineListener(event: Events::prePersist)]
final readonly class SlugListener
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function prePersist(PrePersistEventArgs $event): void
    {
        $object = $event->getObject();

        if ($object instanceof SluggableInterface) {
            $this->generateSlug($object);
        }
    }

    private function generateSlug(SluggableInterface $sluggable): void
    {
        $slug = $this->slugger->slug($sluggable->getSlugSource())->lower()->toString();
        $slug = sprintf('%s-%s', $slug, uniqid());
        $sluggable->setSlug($slug);
    }
}
