<?php

namespace App\DataFixtures\Common;

use Doctrine\Bundle\FixturesBundle\Fixture;

abstract class AbstractFixture extends Fixture
{
    protected function hydrate(object $entity, array $data): void
    {
        $references = $data['_references'] ?? [];
        unset($data['_references']);

        foreach ($references as $key => $reference) {
            $this->hydrateReference($entity, $key, $reference);
        }

        foreach ($data as $key => $value) {
            $this->hydrateProperty($entity, $key, $value);
        }
    }

    private function hydrateProperty(object $entity, string $property, mixed $value): void
    {
        $method = sprintf('set%s', ucfirst($property));

        if (method_exists($entity, $method)) {
            $entity->$method($value);
        }
    }

    private function hydrateReference(object $entity, string $property, array $reference): void
    {
        [$scope, $name] = $reference;

        $value = $this->getReference($name, $scope);
        $this->hydrateProperty($entity, $property, $value);
    }
}
