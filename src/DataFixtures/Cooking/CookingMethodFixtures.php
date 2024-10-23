<?php

namespace App\DataFixtures\Cooking;

use App\Entity\Cooking\CookingMethod;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CookingMethodFixtures extends Fixture implements FixtureGroupInterface
{
    private const METHODS = [
        [
            'label' => 'Plaques de cuisson',
            'icon' => 'baking-tray',
        ],
        [
            'label' => 'Four',
            'icon' => 'oven',
        ],
        [
            'label' => 'Friture',
            'icon' => 'fryer',
        ],
        [
            'label' => 'Vapeur',
            'icon' => 'steam',
        ],
        [
            'label' => 'Grillade / Plancha',
            'icon' => 'grill',
        ],
        [
            'label' => 'Micro-ondes',
            'icon' => 'microwave',
        ],
        [
            'label' => 'Croque-Gaufrier',
            'icon' => 'waffle-iron',
        ],
        [
            'label' => 'Pas de cuisson',
            'icon' => 'no-cooking',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::METHODS as $entry) {
            $method = new CookingMethod();
            $method->setLabel($entry['label']);
            $method->setIcon($entry['icon']);
            $manager->persist($method);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init'];
    }
}
