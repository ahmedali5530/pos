<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906192752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, is_active TINYINT(1) DEFAULT \'1\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, uuid VARCHAR(255) DEFAULT NULL, INDEX IDX_1C52F958EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, original_name VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, extension VARCHAR(255) DEFAULT NULL, mime_type VARCHAR(50) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, uuid VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_brand (product_id INT NOT NULL, brand_id INT NOT NULL, INDEX IDX_BD0E82044584665A (product_id), INDEX IDX_BD0E820444F5D008 (brand_id), PRIMARY KEY(product_id, brand_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_supplier (product_id INT NOT NULL, supplier_id INT NOT NULL, INDEX IDX_509A06E94584665A (product_id), INDEX IDX_509A06E92ADD6D8C (supplier_id), PRIMARY KEY(product_id, supplier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(50) DEFAULT NULL, email VARCHAR(50) DEFAULT NULL, whats_app VARCHAR(50) DEFAULT NULL, fax VARCHAR(50) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) DEFAULT \'1\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, uuid VARCHAR(255) DEFAULT NULL, INDEX IDX_9B2A6C7EEA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brand ADD CONSTRAINT FK_1C52F958EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE product_brand ADD CONSTRAINT FK_BD0E82044584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_brand ADD CONSTRAINT FK_BD0E820444F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_supplier ADD CONSTRAINT FK_509A06E94584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_supplier ADD CONSTRAINT FK_509A06E92ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE supplier ADD CONSTRAINT FK_9B2A6C7EEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE product ADD media_id INT DEFAULT NULL, ADD sale_unit VARCHAR(20) DEFAULT NULL, DROP short_code, CHANGE uom purchase_unit VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADEA9FDD75 ON product (media_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_brand DROP FOREIGN KEY FK_BD0E820444F5D008');
        $this->addSql('ALTER TABLE brand DROP FOREIGN KEY FK_1C52F958EA9FDD75');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADEA9FDD75');
        $this->addSql('ALTER TABLE supplier DROP FOREIGN KEY FK_9B2A6C7EEA9FDD75');
        $this->addSql('ALTER TABLE product_supplier DROP FOREIGN KEY FK_509A06E92ADD6D8C');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE product_brand');
        $this->addSql('DROP TABLE product_supplier');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP INDEX IDX_D34A04ADEA9FDD75 ON product');
        $this->addSql('ALTER TABLE product ADD uom VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD short_code VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP media_id, DROP purchase_unit, DROP sale_unit');
    }
}
