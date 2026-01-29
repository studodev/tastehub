<?php

namespace App\DataFixtures\Cooking;

use App\DataFixtures\Common\AbstractFixture;
use App\Entity\Cooking\Tag;
use App\Service\Common\JsonDataLoader;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends AbstractFixture implements FixtureGroupInterface
{
    public function __construct(private readonly JsonDataLoader $jsonDataLoader)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $data = $this->jsonDataLoader->load('tags');

        foreach ($data['items'] as $entry) {
            $tag = new Tag();
            $this->hydrate($tag, $entry);
            $manager->persist($tag);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init', 'tag'];
    }
}
