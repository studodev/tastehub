<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240905131753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add ingredient tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, type_id INT NOT NULL, INDEX IDX_6BAF7870C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE ingredient_type (id INT AUTO_INCREMENT NOT NULL, pictogram VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870C54C8C93 FOREIGN KEY (type_id) REFERENCES ingredient_type (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870C54C8C93');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE ingredient_type');
    }
}
