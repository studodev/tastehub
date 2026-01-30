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
            'label' => 'Gramme',
            'type' => UnitTypeEnum::Mass,
            'baseFactor' => 1,
            'baseUnit' => null,
        ],
        'milligram' => [
            'symbol' => 'mg',
            'label' => 'Milligramme',
            'type' => UnitTypeEnum::Mass,
            'baseFactor' => 0.001,
            '_references' => [
                'baseUnit' => [Unit::class, 'gram'],
            ],
        ],
        'kilogram' => [
            'symbol' => 'kg',
            'label' => 'Kilogramme',
            'type' => UnitTypeEnum::Mass,
            'baseFactor' => 1000,
            '_references' => [
                'baseUnit' => [Unit::class, 'gram'],
            ],
        ],
        'milliliter' => [
            'symbol' => 'ml',
            'label' => 'Millilitre',
            'type' => UnitTypeEnum::Volume,
            'baseFactor' => 1,
            'baseUnit' => null,
        ],
        'liter' => [
            'symbol' => 'l',
            'label' => 'Litre',
            'type' => UnitTypeEnum::Volume,
            'baseFactor' => 1000,
            '_references' => [
                'baseUnit' => [Unit::class, 'milliliter'],
            ],
        ],
        'centiliter' => [
            'symbol' => 'cl',
            'label' => 'Centilitre',
            'type' => UnitTypeEnum::Volume,
            'baseFactor' => 10,
            '_references' => [
                'baseUnit' => [Unit::class, 'milliliter'],
            ],
        ],
        'teaspoon' => [
            'symbol' => 'càc',
            'label' => 'Cuillère à café',
            'type' => UnitTypeEnum::Count,
        ],
        'tablespoon' => [
            'symbol' => 'càs',
            'label' => 'Cuillère à soupe',
            'type' => UnitTypeEnum::Count,
        ],
        'cup' => [
            'symbol' => 'tasse',
            'label' => 'Tasse',
            'type' => UnitTypeEnum::Count,
        ],
        'pot' => [
            'symbol' => 'pot',
            'label' => 'Pot',
            'type' => UnitTypeEnum::Count,
        ],
        'piece' => [
            'symbol' => 'pièce',
            'label' => 'Pièce',
            'type' => UnitTypeEnum::Count,
        ],
        'pinch' => [
            'symbol' => 'une pincée',
            'label' => 'Pincée',
            'type' => UnitTypeEnum::Empirical,
        ],
        'splash' => [
            'symbol' => 'un filet',
            'label' => 'Filet',
            'type' => UnitTypeEnum::Empirical,
        ],
        'taste' => [
            'symbol' => 'selon le goût',
            'label' => 'Selon le goût',
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
