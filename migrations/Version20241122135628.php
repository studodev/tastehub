<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241122135628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add label on ingredient types';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE ingredient_type ADD label VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE ingredient_type DROP label');
    }
}
