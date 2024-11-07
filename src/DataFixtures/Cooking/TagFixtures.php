<?php

namespace App\DataFixtures\Cooking;

use App\Entity\Cooking\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends Fixture implements FixtureGroupInterface
{
    private const TAGS = [
        'Noël', 'Fraîcheur', 'Sucré / Salé', 'Fêtes', 'Healthy', 'Réconfortant',
        'Français', 'Italien', 'Belge', 'Méditerranéen', 'Libanais',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::TAGS as $entry) {
            $tag = new Tag();
            $tag->setLabel($entry);
            $manager->persist($tag);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init'];
    }
}
