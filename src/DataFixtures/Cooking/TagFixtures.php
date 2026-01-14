<?php

namespace App\DataFixtures\Cooking;

use App\DataFixtures\Common\AbstractFixture;
use App\Entity\Cooking\Tag;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends AbstractFixture implements FixtureGroupInterface
{
    private const array TAGS = [
        [
            'label' => 'Noël',
        ],
        [
            'label' => 'Fraîcheur',
        ],
        [
            'label' => 'Fêtes',
        ],
        [
            'label' => 'Healthy',
        ],
        [
            'label' => 'Réconfortant',
        ],
        [
            'label' => 'Français',
        ],
        [
            'label' => 'Italien',
        ],
        [
            'label' => 'Belge',
        ],
        [
            'label' => 'Sucré / Salé',
        ],
        [
            'label' => 'Méditerranéen',
        ],
        [
            'label' => 'Libanais',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::TAGS as $entry) {
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
