<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211228110907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer ADD created_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE location ADD created_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD is_active TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD created_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE order_discount ADD created_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE order_payment ADD created_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE order_product ADD created_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE order_tax ADD created_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD is_active TINYINT(1) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product_price ADD created_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product_variant ADD created_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE store ADD is_active TINYINT(1) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE tax ADD is_active TINYINT(1) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer DROP created_at, DROP deleted_at, DROP updated_at');
        $this->addSql('ALTER TABLE location DROP created_at, DROP deleted_at, DROP updated_at, DROP is_active');
        $this->addSql('ALTER TABLE `order` DROP created_at, DROP deleted_at, DROP updated_at');
        $this->addSql('ALTER TABLE order_discount DROP created_at, DROP deleted_at, DROP updated_at');
        $this->addSql('ALTER TABLE order_payment DROP created_at, DROP deleted_at, DROP updated_at');
        $this->addSql('ALTER TABLE order_product DROP created_at, DROP deleted_at, DROP updated_at');
        $this->addSql('ALTER TABLE order_tax DROP created_at, DROP deleted_at, DROP updated_at');
        $this->addSql('ALTER TABLE product DROP is_active, DROP created_at, DROP deleted_at, DROP updated_at');
        $this->addSql('ALTER TABLE product_price DROP created_at, DROP deleted_at, DROP updated_at');
        $this->addSql('ALTER TABLE product_variant DROP created_at, DROP deleted_at, DROP updated_at');
        $this->addSql('ALTER TABLE store DROP is_active, DROP created_at, DROP deleted_at, DROP updated_at');
        $this->addSql('ALTER TABLE tax DROP is_active, DROP created_at, DROP deleted_at, DROP updated_at');
    }
}
