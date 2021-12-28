<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211228105647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(20) DEFAULT NULL, birthday DATE DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discount (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, rate NUMERIC(20, 2) NOT NULL, rate_type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, user_id INT DEFAULT NULL, order_id INT NOT NULL, is_suspended TINYINT(1) DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, is_returned TINYINT(1) DEFAULT NULL, is_dispatched TINYINT(1) DEFAULT NULL, INDEX IDX_F52993989395C3F3 (customer_id), INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_discount (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, rate NUMERIC(20, 2) NOT NULL, amount NUMERIC(20, 2) NOT NULL, orderId INT DEFAULT NULL, UNIQUE INDEX UNIQ_1856BFFA237437 (orderId), INDEX IDX_1856BFC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_payment (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, total NUMERIC(20, 2) NOT NULL, received NUMERIC(20, 2) NOT NULL, due NUMERIC(20, 2) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_9B522D468D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_product (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, variant_id INT DEFAULT NULL, quantity NUMERIC(20, 2) NOT NULL, price NUMERIC(20, 2) NOT NULL, is_suspended TINYINT(1) DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, is_returned TINYINT(1) DEFAULT NULL, orderId INT DEFAULT NULL, INDEX IDX_2530ADE64584665A (product_id), INDEX IDX_2530ADE63B69A9AF (variant_id), INDEX IDX_2530ADE6FA237437 (orderId), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_tax (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, rate NUMERIC(20, 2) NOT NULL, amount NUMERIC(20, 2) NOT NULL, orderId INT DEFAULT NULL, UNIQUE INDEX UNIQ_CDDAF516FA237437 (orderId), INDEX IDX_CDDAF516C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, sku VARCHAR(255) DEFAULT NULL, barcode VARCHAR(255) DEFAULT NULL, base_quantity INT DEFAULT NULL, is_available TINYINT(1) DEFAULT NULL, base_price NUMERIC(20, 2) DEFAULT NULL, quantity NUMERIC(20, 2) DEFAULT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_price (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, product_variant_id INT DEFAULT NULL, date DATE DEFAULT NULL, time TIME DEFAULT NULL, day VARCHAR(20) DEFAULT NULL, rate NUMERIC(20, 2) DEFAULT NULL, min_quantity NUMERIC(20, 2) DEFAULT NULL, max_quantity NUMERIC(20, 2) DEFAULT NULL, base_price NUMERIC(20, 2) NOT NULL, base_quantity NUMERIC(20, 2) DEFAULT NULL, INDEX IDX_6B9459854584665A (product_id), INDEX IDX_6B945985A80EF684 (product_variant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_variant (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, size VARCHAR(255) DEFAULT NULL, color VARCHAR(20) DEFAULT NULL, weight VARCHAR(255) DEFAULT NULL, barcode VARCHAR(255) DEFAULT NULL, sku VARCHAR(255) DEFAULT NULL, price NUMERIC(20, 2) DEFAULT NULL, INDEX IDX_209AA41D4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_FF57587764D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tax (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, rate NUMERIC(20, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_discount ADD CONSTRAINT FK_1856BFFA237437 FOREIGN KEY (orderId) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_discount ADD CONSTRAINT FK_1856BFC54C8C93 FOREIGN KEY (type_id) REFERENCES discount (id)');
        $this->addSql('ALTER TABLE order_payment ADD CONSTRAINT FK_9B522D468D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE64584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE63B69A9AF FOREIGN KEY (variant_id) REFERENCES product_variant (id)');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE6FA237437 FOREIGN KEY (orderId) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_tax ADD CONSTRAINT FK_CDDAF516FA237437 FOREIGN KEY (orderId) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_tax ADD CONSTRAINT FK_CDDAF516C54C8C93 FOREIGN KEY (type_id) REFERENCES tax (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product_price ADD CONSTRAINT FK_6B9459854584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_price ADD CONSTRAINT FK_6B945985A80EF684 FOREIGN KEY (product_variant_id) REFERENCES product_variant (id)');
        $this->addSql('ALTER TABLE product_variant ADD CONSTRAINT FK_209AA41D4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF57587764D218E FOREIGN KEY (location_id) REFERENCES location (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE order_discount DROP FOREIGN KEY FK_1856BFC54C8C93');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF57587764D218E');
        $this->addSql('ALTER TABLE order_discount DROP FOREIGN KEY FK_1856BFFA237437');
        $this->addSql('ALTER TABLE order_payment DROP FOREIGN KEY FK_9B522D468D9F6D38');
        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE6FA237437');
        $this->addSql('ALTER TABLE order_tax DROP FOREIGN KEY FK_CDDAF516FA237437');
        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE64584665A');
        $this->addSql('ALTER TABLE product_price DROP FOREIGN KEY FK_6B9459854584665A');
        $this->addSql('ALTER TABLE product_variant DROP FOREIGN KEY FK_209AA41D4584665A');
        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE63B69A9AF');
        $this->addSql('ALTER TABLE product_price DROP FOREIGN KEY FK_6B945985A80EF684');
        $this->addSql('ALTER TABLE order_tax DROP FOREIGN KEY FK_CDDAF516C54C8C93');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE discount');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_discount');
        $this->addSql('DROP TABLE order_payment');
        $this->addSql('DROP TABLE order_product');
        $this->addSql('DROP TABLE order_tax');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_price');
        $this->addSql('DROP TABLE product_variant');
        $this->addSql('DROP TABLE store');
        $this->addSql('DROP TABLE tax');
    }
}
