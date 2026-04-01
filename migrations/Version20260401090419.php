<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260401090419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add average_rating column to recipe table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE recipe ADD average_rating DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE recipe DROP average_rating');
    }
}
