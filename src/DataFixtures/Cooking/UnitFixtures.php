<?php

namespace App\DataFixtures\Cooking;

use App\Entity\Cooking\Unit;
use App\Enum\Cooking\UnitTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UnitFixtures extends Fixture implements FixtureGroupInterface
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
            'baseUnit' => 'gram',
        ],
        'kilogram' => [
            'symbol' => 'kg',
            'label' => 'Kilogramme',
            'type' => UnitTypeEnum::Mass,
            'baseFactor' => 1000,
            'baseUnit' => 'gram',
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
            'baseUnit' => 'milliliter',
        ],
        'centiliter' => [
            'symbol' => 'cl',
            'label' => 'Centilitre',
            'type' => UnitTypeEnum::Volume,
            'baseFactor' => 10,
            'baseUnit' => 'milliliter',
        ],
        'teaspoon' => [
            'symbol' => 'càc',
            'label' => 'Cuillère à café',
            'type' => UnitTypeEnum::Count,
            'baseFactor' => null,
            'baseUnit' => null,
        ],
        'tablespoon' => [
            'symbol' => 'càs',
            'label' => 'Cuillère à soupe',
            'type' => UnitTypeEnum::Count,
            'baseFactor' => null,
            'baseUnit' => null,
        ],
        'cup' => [
            'symbol' => 'tasse',
            'label' => 'Tasse',
            'type' => UnitTypeEnum::Count,
            'baseFactor' => null,
            'baseUnit' => null,
        ],
        'pot' => [
            'symbol' => 'pot',
            'label' => 'Pot',
            'type' => UnitTypeEnum::Count,
            'baseFactor' => null,
            'baseUnit' => null,
        ],
        'piece' => [
            'symbol' => 'pièce',
            'label' => 'Pièce',
            'type' => UnitTypeEnum::Count,
            'baseFactor' => null,
            'baseUnit' => null,
        ],
        'pinch' => [
            'symbol' => 'pincée',
            'label' => 'Pincée',
            'type' => UnitTypeEnum::Empirical,
            'baseFactor' => null,
            'baseUnit' => null,
        ],
        'splash' => [
            'symbol' => 'filet',
            'label' => 'Filet',
            'type' => UnitTypeEnum::Empirical,
            'baseFactor' => null,
            'baseUnit' => null,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::UNITS as $key => $entry) {
            $unit = new Unit();
            $unit->setSymbol($entry['symbol']);
            $unit->setLabel($entry['label']);
            $unit->setType($entry['type']);
            $unit->setBaseFactor($entry['baseFactor']);

            if (null !== $entry['baseUnit']) {
                $baseUnit = $this->getReference(sprintf('unit_%s', $entry['baseUnit']), Unit::class);
                $unit->setBaseUnit($baseUnit);
            }

            $this->addReference(sprintf('unit_%s', $key), $unit);
            $manager->persist($unit);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['init', 'unit'];
    }
}
