<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220905050421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE customer CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE customer_payment CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE discount CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE expense CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE location CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE `order` CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE order_discount CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE order_payment CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE order_product CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE order_tax CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE payment CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE product CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE product_price CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE product_variant CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE store CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE tax CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE customer CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE customer_payment CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE discount CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE expense CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE location CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE order_discount CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE order_payment CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE order_product CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE order_tax CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE payment CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product_price CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product_variant CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE store CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE tax CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE created_at created_at DATETIME DEFAULT NULL');
    }
}
