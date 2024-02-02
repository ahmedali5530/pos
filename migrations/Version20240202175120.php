<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240202175120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_product_attribute (product_id INT NOT NULL, product_attribute_id INT NOT NULL, INDEX IDX_205F6B254584665A (product_id), INDEX IDX_205F6B253B420C91 (product_attribute_id), PRIMARY KEY(product_id, product_attribute_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_attribute (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, value LONGTEXT DEFAULT NULL, type VARCHAR(255) NOT NULL, index_on_search TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_product_attribute ADD CONSTRAINT FK_205F6B254584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_product_attribute ADD CONSTRAINT FK_205F6B253B420C91 FOREIGN KEY (product_attribute_id) REFERENCES product_attribute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer ADD allow_credit_sale TINYINT(1) DEFAULT NULL, ADD credit_limit NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD is_expire TINYINT(1) DEFAULT NULL, ADD inventory_method VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE purchase_item ADD is_expire TINYINT(1) DEFAULT NULL, ADD expiry_date DATE DEFAULT NULL, ADD quantity_used NUMERIC(10, 2) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_product_attribute DROP FOREIGN KEY FK_205F6B253B420C91');
        $this->addSql('DROP TABLE product_product_attribute');
        $this->addSql('DROP TABLE product_attribute');
        $this->addSql('ALTER TABLE customer DROP allow_credit_sale, DROP credit_limit');
        $this->addSql('ALTER TABLE product DROP is_expire, DROP inventory_method');
        $this->addSql('ALTER TABLE purchase_item DROP is_expire, DROP expiry_date, DROP quantity_used');
    }
}
