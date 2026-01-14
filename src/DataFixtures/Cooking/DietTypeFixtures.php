<?php

namespace App\DataFixtures\Cooking;

use App\DataFixtures\Common\AbstractFixture;
use App\Entity\Cooking\DietType;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class DietTypeFixtures extends AbstractFixture implements FixtureGroupInterface
{
    private const array DIETS = [
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
            $this->hydrate($dietType, $entry);
            $manager->persist($dietType);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init', 'diet_type'];
    }
}
