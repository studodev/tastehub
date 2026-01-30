<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260130152930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Allow null quantity on recipe_ingredient';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE recipe_ingredient CHANGE quantity quantity DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE recipe_ingredient CHANGE quantity quantity DOUBLE PRECISION NOT NULL');
    }
}
