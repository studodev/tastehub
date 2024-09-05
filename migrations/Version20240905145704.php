<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240905145704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add recipe tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(60) NOT NULL, description LONGTEXT DEFAULT NULL, picture VARCHAR(255) NOT NULL, timer JSON NOT NULL, quantity_counter JSON NOT NULL, category_id INT NOT NULL, INDEX IDX_DA88B13712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE recipe_diet_type (recipe_id INT NOT NULL, diet_type_id INT NOT NULL, INDEX IDX_6107ADCA59D8A214 (recipe_id), INDEX IDX_6107ADCA35BFD6CF (diet_type_id), PRIMARY KEY(recipe_id, diet_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE recipe_cooking_method (recipe_id INT NOT NULL, cooking_method_id INT NOT NULL, INDEX IDX_A5B727B59D8A214 (recipe_id), INDEX IDX_A5B727BD1C3927 (cooking_method_id), PRIMARY KEY(recipe_id, cooking_method_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE recipe_tag (recipe_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_72DED3CF59D8A214 (recipe_id), INDEX IDX_72DED3CFBAD26311 (tag_id), PRIMARY KEY(recipe_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE recipe_ingredient (id INT AUTO_INCREMENT NOT NULL, quantity DOUBLE PRECISION NOT NULL, unit VARCHAR(10) NOT NULL, recipe_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_22D1FE1359D8A214 (recipe_id), INDEX IDX_22D1FE13933FE08C (ingredient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE step (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, number INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_43B9FE3C59D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE step_recipe_ingredient (step_id INT NOT NULL, recipe_ingredient_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, INDEX IDX_B56C9F1173B21E9C (step_id), INDEX IDX_B56C9F113CAF64A (recipe_ingredient_id), PRIMARY KEY(step_id, recipe_ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B13712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE recipe_diet_type ADD CONSTRAINT FK_6107ADCA59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_diet_type ADD CONSTRAINT FK_6107ADCA35BFD6CF FOREIGN KEY (diet_type_id) REFERENCES diet_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_cooking_method ADD CONSTRAINT FK_A5B727B59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_cooking_method ADD CONSTRAINT FK_A5B727BD1C3927 FOREIGN KEY (cooking_method_id) REFERENCES cooking_method (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_tag ADD CONSTRAINT FK_72DED3CF59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_tag ADD CONSTRAINT FK_72DED3CFBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE1359D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE13933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE step_recipe_ingredient ADD CONSTRAINT FK_B56C9F1173B21E9C FOREIGN KEY (step_id) REFERENCES step (id)');
        $this->addSql('ALTER TABLE step_recipe_ingredient ADD CONSTRAINT FK_B56C9F113CAF64A FOREIGN KEY (recipe_ingredient_id) REFERENCES recipe_ingredient (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B13712469DE2');
        $this->addSql('ALTER TABLE recipe_diet_type DROP FOREIGN KEY FK_6107ADCA59D8A214');
        $this->addSql('ALTER TABLE recipe_diet_type DROP FOREIGN KEY FK_6107ADCA35BFD6CF');
        $this->addSql('ALTER TABLE recipe_cooking_method DROP FOREIGN KEY FK_A5B727B59D8A214');
        $this->addSql('ALTER TABLE recipe_cooking_method DROP FOREIGN KEY FK_A5B727BD1C3927');
        $this->addSql('ALTER TABLE recipe_tag DROP FOREIGN KEY FK_72DED3CF59D8A214');
        $this->addSql('ALTER TABLE recipe_tag DROP FOREIGN KEY FK_72DED3CFBAD26311');
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE1359D8A214');
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE13933FE08C');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C59D8A214');
        $this->addSql('ALTER TABLE step_recipe_ingredient DROP FOREIGN KEY FK_B56C9F1173B21E9C');
        $this->addSql('ALTER TABLE step_recipe_ingredient DROP FOREIGN KEY FK_B56C9F113CAF64A');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipe_diet_type');
        $this->addSql('DROP TABLE recipe_cooking_method');
        $this->addSql('DROP TABLE recipe_tag');
        $this->addSql('DROP TABLE recipe_ingredient');
        $this->addSql('DROP TABLE step');
        $this->addSql('DROP TABLE step_recipe_ingredient');
    }
}
