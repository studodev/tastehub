<?php

namespace App\DataFixtures\Cooking;

use App\Entity\Cooking\Utensil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UtensilFixtures extends Fixture implements FixtureGroupInterface
{
    private const UTENSILS = [
        [
            'label' => 'Blender',
            'pictogram' => 'beer.svg',
        ],
        [
            'label' => 'Batteur',
            'pictogram' => 'butter.svg',
        ],
        [
            'label' => 'Moule à cake',
            'pictogram' => 'cheese.svg',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::UTENSILS as $entry) {
            $utensil = new Utensil();
            $utensil->setLabel($entry['label']);
            $utensil->setPictogram($entry['pictogram']);

            $manager->persist($utensil);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init'];
    }
}
