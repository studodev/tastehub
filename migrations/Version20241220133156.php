<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241220133156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add utensil recipe link';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE recipe_utensil (recipe_id INT NOT NULL, utensil_id INT NOT NULL, INDEX IDX_D3CC32FC59D8A214 (recipe_id), INDEX IDX_D3CC32FCEC4313DE (utensil_id), PRIMARY KEY(recipe_id, utensil_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE recipe_utensil ADD CONSTRAINT FK_D3CC32FC59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_utensil ADD CONSTRAINT FK_D3CC32FCEC4313DE FOREIGN KEY (utensil_id) REFERENCES utensil (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE recipe_utensil DROP FOREIGN KEY FK_D3CC32FC59D8A214');
        $this->addSql('ALTER TABLE recipe_utensil DROP FOREIGN KEY FK_D3CC32FCEC4313DE');
        $this->addSql('DROP TABLE recipe_utensil');
    }
}
