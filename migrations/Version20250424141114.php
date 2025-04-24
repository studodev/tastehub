<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250424141114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Allow null picture on recipe';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE recipe CHANGE picture picture VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE recipe CHANGE picture picture VARCHAR(255) NOT NULL');
    }
}
