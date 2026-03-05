<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260305110045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Setup initial database';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(30) NOT NULL, slug VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_64C19C1989D9B62 (slug), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE cooking_method (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, icon VARCHAR(30) NOT NULL, singular TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE diet_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(30) NOT NULL, icon VARCHAR(30) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, type_id INT NOT NULL, INDEX IDX_6BAF7870C54C8C93 (type_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE ingredient_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, pictogram VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE recipe (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(60) NOT NULL, description LONGTEXT DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, state VARCHAR(255) NOT NULL, timer JSON NOT NULL, quantity_counter JSON NOT NULL, slug VARCHAR(180) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, category_id INT NOT NULL, author_id INT NOT NULL, UNIQUE INDEX UNIQ_DA88B137989D9B62 (slug), INDEX IDX_DA88B13712469DE2 (category_id), INDEX IDX_DA88B137F675F31B (author_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE recipe_diet_type (recipe_id INT NOT NULL, diet_type_id INT NOT NULL, INDEX IDX_6107ADCA59D8A214 (recipe_id), INDEX IDX_6107ADCA35BFD6CF (diet_type_id), PRIMARY KEY (recipe_id, diet_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE recipe_cooking_method (recipe_id INT NOT NULL, cooking_method_id INT NOT NULL, INDEX IDX_A5B727B59D8A214 (recipe_id), INDEX IDX_A5B727BD1C3927 (cooking_method_id), PRIMARY KEY (recipe_id, cooking_method_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE recipe_tag (recipe_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_72DED3CF59D8A214 (recipe_id), INDEX IDX_72DED3CFBAD26311 (tag_id), PRIMARY KEY (recipe_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE recipe_utensil (recipe_id INT NOT NULL, utensil_id INT NOT NULL, INDEX IDX_D3CC32FC59D8A214 (recipe_id), INDEX IDX_D3CC32FCEC4313DE (utensil_id), PRIMARY KEY (recipe_id, utensil_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE recipe_ingredient (id INT AUTO_INCREMENT NOT NULL, quantity DOUBLE PRECISION DEFAULT NULL, recipe_id INT NOT NULL, ingredient_id INT NOT NULL, unit_id INT DEFAULT NULL, INDEX IDX_22D1FE1359D8A214 (recipe_id), INDEX IDX_22D1FE13933FE08C (ingredient_id), INDEX IDX_22D1FE13F8BD700D (unit_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(255) NOT NULL, expire_at DATETIME NOT NULL, user_id INT NOT NULL, INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE step (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, number INT NOT NULL, recipe_id INT NOT NULL, INDEX IDX_43B9FE3C59D8A214 (recipe_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE step_recipe_ingredient (step_id INT NOT NULL, recipe_ingredient_id INT NOT NULL, INDEX IDX_B56C9F1173B21E9C (step_id), INDEX IDX_B56C9F113CAF64A (recipe_ingredient_id), PRIMARY KEY (step_id, recipe_ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(30) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, symbol VARCHAR(20) NOT NULL, label VARCHAR(50) NOT NULL, type VARCHAR(20) NOT NULL, base_factor DOUBLE PRECISION DEFAULT NULL, base_unit_id INT DEFAULT NULL, INDEX IDX_DCBB0C53CCBBC969 (base_unit_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(24) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, slug VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_8D93D649989D9B62 (slug), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), UNIQUE INDEX UNIQ_USERNAME (username), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE utensil (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(30) NOT NULL, pictogram VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF7870C54C8C93 FOREIGN KEY (type_id) REFERENCES ingredient_type (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B13712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recipe_diet_type ADD CONSTRAINT FK_6107ADCA59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_diet_type ADD CONSTRAINT FK_6107ADCA35BFD6CF FOREIGN KEY (diet_type_id) REFERENCES diet_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_cooking_method ADD CONSTRAINT FK_A5B727B59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_cooking_method ADD CONSTRAINT FK_A5B727BD1C3927 FOREIGN KEY (cooking_method_id) REFERENCES cooking_method (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_tag ADD CONSTRAINT FK_72DED3CF59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_tag ADD CONSTRAINT FK_72DED3CFBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_utensil ADD CONSTRAINT FK_D3CC32FC59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_utensil ADD CONSTRAINT FK_D3CC32FCEC4313DE FOREIGN KEY (utensil_id) REFERENCES utensil (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE1359D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE13933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE recipe_ingredient ADD CONSTRAINT FK_22D1FE13F8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id)');
        $this->addSql('ALTER TABLE step_recipe_ingredient ADD CONSTRAINT FK_B56C9F1173B21E9C FOREIGN KEY (step_id) REFERENCES step (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE step_recipe_ingredient ADD CONSTRAINT FK_B56C9F113CAF64A FOREIGN KEY (recipe_ingredient_id) REFERENCES recipe_ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE unit ADD CONSTRAINT FK_DCBB0C53CCBBC969 FOREIGN KEY (base_unit_id) REFERENCES unit (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF7870C54C8C93');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B13712469DE2');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137F675F31B');
        $this->addSql('ALTER TABLE recipe_diet_type DROP FOREIGN KEY FK_6107ADCA59D8A214');
        $this->addSql('ALTER TABLE recipe_diet_type DROP FOREIGN KEY FK_6107ADCA35BFD6CF');
        $this->addSql('ALTER TABLE recipe_cooking_method DROP FOREIGN KEY FK_A5B727B59D8A214');
        $this->addSql('ALTER TABLE recipe_cooking_method DROP FOREIGN KEY FK_A5B727BD1C3927');
        $this->addSql('ALTER TABLE recipe_tag DROP FOREIGN KEY FK_72DED3CF59D8A214');
        $this->addSql('ALTER TABLE recipe_tag DROP FOREIGN KEY FK_72DED3CFBAD26311');
        $this->addSql('ALTER TABLE recipe_utensil DROP FOREIGN KEY FK_D3CC32FC59D8A214');
        $this->addSql('ALTER TABLE recipe_utensil DROP FOREIGN KEY FK_D3CC32FCEC4313DE');
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE1359D8A214');
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE13933FE08C');
        $this->addSql('ALTER TABLE recipe_ingredient DROP FOREIGN KEY FK_22D1FE13F8BD700D');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C59D8A214');
        $this->addSql('ALTER TABLE step_recipe_ingredient DROP FOREIGN KEY FK_B56C9F1173B21E9C');
        $this->addSql('ALTER TABLE step_recipe_ingredient DROP FOREIGN KEY FK_B56C9F113CAF64A');
        $this->addSql('ALTER TABLE unit DROP FOREIGN KEY FK_DCBB0C53CCBBC969');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE cooking_method');
        $this->addSql('DROP TABLE diet_type');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE ingredient_type');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE recipe_diet_type');
        $this->addSql('DROP TABLE recipe_cooking_method');
        $this->addSql('DROP TABLE recipe_tag');
        $this->addSql('DROP TABLE recipe_utensil');
        $this->addSql('DROP TABLE recipe_ingredient');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE step');
        $this->addSql('DROP TABLE step_recipe_ingredient');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE utensil');
    }
}
