<?php

namespace App\DataFixtures\Cooking;

use App\DataFixtures\Common\AbstractFixture;
use App\Entity\Cooking\Unit;
use App\Enum\Cooking\UnitTypeEnum;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UnitFixtures extends AbstractFixture implements FixtureGroupInterface
{
    private const array UNITS = [
        'gram' => [
            'symbol' => 'g',
            'label' => 'gramme',
            'type' => UnitTypeEnum::Mass,
            'baseFactor' => 1,
            'baseUnit' => null,
        ],
        'milligram' => [
            'symbol' => 'mg',
            'label' => 'milligramme',
            'type' => UnitTypeEnum::Mass,
            'baseFactor' => 0.001,
            '_references' => [
                'baseUnit' => [Unit::class, 'gram'],
            ],
        ],
        'kilogram' => [
            'symbol' => 'kg',
            'label' => 'kilogramme',
            'type' => UnitTypeEnum::Mass,
            'baseFactor' => 1000,
            '_references' => [
                'baseUnit' => [Unit::class, 'gram'],
            ],
        ],
        'milliliter' => [
            'symbol' => 'ml',
            'label' => 'millilitre',
            'type' => UnitTypeEnum::Volume,
            'baseFactor' => 1,
            'baseUnit' => null,
        ],
        'liter' => [
            'symbol' => 'l',
            'label' => 'litre',
            'type' => UnitTypeEnum::Volume,
            'baseFactor' => 1000,
            '_references' => [
                'baseUnit' => [Unit::class, 'milliliter'],
            ],
        ],
        'centiliter' => [
            'symbol' => 'cl',
            'label' => 'centilitre',
            'type' => UnitTypeEnum::Volume,
            'baseFactor' => 10,
            '_references' => [
                'baseUnit' => [Unit::class, 'milliliter'],
            ],
        ],
        'teaspoon' => [
            'symbol' => 'càc',
            'label' => 'cuillère à café',
            'type' => UnitTypeEnum::Count,
        ],
        'tablespoon' => [
            'symbol' => 'càs',
            'label' => 'cuillère à soupe',
            'type' => UnitTypeEnum::Count,
        ],
        'cup' => [
            'label' => 'tasse',
            'type' => UnitTypeEnum::Count,
        ],
        'pot' => [
            'label' => 'pot',
            'type' => UnitTypeEnum::Count,
        ],
        'piece' => [
            'label' => 'pièce',
            'type' => UnitTypeEnum::Count,
        ],
        'pinch' => [
            'symbol' => 'une pincée',
            'label' => 'pincée',
            'type' => UnitTypeEnum::Empirical,
        ],
        'splash' => [
            'symbol' => 'un filet',
            'label' => 'filet',
            'type' => UnitTypeEnum::Empirical,
        ],
        'taste' => [
            'label' => 'selon le goût',
            'type' => UnitTypeEnum::Empirical,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::UNITS as $key => $entry) {
            $unit = new Unit();
            $this->hydrate($unit, $entry);
            $this->addReference($key, $unit);
            $manager->persist($unit);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init', 'unit'];
    }
}
