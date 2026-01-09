<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260109133514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add unit table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, symbol VARCHAR(20) NOT NULL, label VARCHAR(50) NOT NULL, type VARCHAR(20) NOT NULL, base_factor DOUBLE PRECISION DEFAULT NULL, base_unit_id INT DEFAULT NULL, INDEX IDX_DCBB0C53CCBBC969 (base_unit_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C53CCBBC969 FOREIGN KEY (base_unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE recipe_ingredient ADD unit_id INT DEFAULT NULL, DROP unit');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE13F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('CREATE INDEX IDX_22D1FE13F8BD700D ON recipe_ingredient (unit_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE13F8BD700D');
        $this->addSql('DROP INDEX IDX_22D1FE13F8BD700D ON recipe_ingredient');
        $this->addSql('ALTER TABLE recipe_ingredient ADD unit VARCHAR(10) NOT NULL, DROP unit_id');
        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C53CCBBC969');
        $this->addSql('DROP TABLE unit');
    }
}
