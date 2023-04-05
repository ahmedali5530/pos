<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307063812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, supplier_id INT DEFAULT NULL, store_id INT NOT NULL, purchased_by_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_stocks TINYINT(1) DEFAULT NULL, update_price TINYINT(1) DEFAULT NULL, INDEX IDX_6117D13B2ADD6D8C (supplier_id), INDEX IDX_6117D13BB092A811 (store_id), INDEX IDX_6117D13B51D43F65 (purchased_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_item (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, purchase_id INT NOT NULL, quantity NUMERIC(10, 2) NOT NULL, purchase_price NUMERIC(10, 2) NOT NULL, purchase_unit VARCHAR(255) NOT NULL, barcode VARCHAR(255) DEFAULT NULL, INDEX IDX_6FA8ED7D126F525E (item_id), INDEX IDX_6FA8ED7D558FBEB9 (purchase_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_order (id INT AUTO_INCREMENT NOT NULL, supplier_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_21E210B22ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_order_item (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, purchase_order_id INT NOT NULL, ite VARCHAR(255) NOT NULL, quantity NUMERIC(10, 2) NOT NULL, price NUMERIC(10, 2) NOT NULL, unit VARCHAR(255) DEFAULT NULL, INDEX IDX_5ED948C3126F525E (item_id), INDEX IDX_5ED948C3A45D7E6A (purchase_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BB092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B51D43F65 FOREIGN KEY (purchased_by_id) REFERENCES user_account (id)');
        $this->addSql('ALTER TABLE purchase_item ADD CONSTRAINT FK_6FA8ED7D126F525E FOREIGN KEY (item_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE purchase_item ADD CONSTRAINT FK_6FA8ED7D558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id)');
        $this->addSql('ALTER TABLE purchase_order ADD CONSTRAINT FK_21E210B22ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE purchase_order_item ADD CONSTRAINT FK_5ED948C3126F525E FOREIGN KEY (item_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE purchase_order_item ADD CONSTRAINT FK_5ED948C3A45D7E6A FOREIGN KEY (purchase_order_id) REFERENCES purchase_order (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE purchase_item DROP FOREIGN KEY FK_6FA8ED7D558FBEB9');
        $this->addSql('ALTER TABLE purchase_order_item DROP FOREIGN KEY FK_5ED948C3A45D7E6A');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE purchase_item');
        $this->addSql('DROP TABLE purchase_order');
        $this->addSql('DROP TABLE purchase_order_item');
    }
}
