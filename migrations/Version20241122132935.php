<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241122132935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add singular column on cooking methods';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE cooking_method ADD singular TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE cooking_method DROP singular');
    }
}
