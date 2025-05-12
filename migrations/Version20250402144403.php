<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250402144403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add createdAt and updatedAt on recipe';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE recipe ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE recipe DROP created_at, DROP updated_at');
    }
}
