<?php

namespace App\DataFixtures\Cooking;

use App\Entity\Cooking\DietType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class DietTypeFixtures extends Fixture implements FixtureGroupInterface
{
    private const DIETS = [
        [
            'label' => 'Sans gluten',
            'icon' => 'no-gluten',
        ],
        [
            'label' => 'Sans lactose',
            'icon' => 'no-dairy',
        ],
        [
            'label' => 'Végétarien',
            'icon' => 'vegetarian',
        ],
        [
            'label' => 'Végétalien',
            'icon' => 'vegan',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DIETS as $entry) {
            $dietType = new DietType();
            $dietType->setLabel($entry['label']);
            $dietType->setIcon($entry['icon']);
            $manager->persist($dietType);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init'];
    }
}
