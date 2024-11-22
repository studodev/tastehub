<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240905150836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove Doctrine comment in tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE reset_password_request CHANGE expire_at expire_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE reset_password_request CHANGE expire_at expire_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
