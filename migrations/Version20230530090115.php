<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230530090115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE purchase_order_item_variant (id INT AUTO_INCREMENT NOT NULL, variant_id INT NOT NULL, purchase_order_item_id INT NOT NULL, quantity NUMERIC(10, 2) NOT NULL, purchase_price NUMERIC(10, 2) NOT NULL, purchase_unit VARCHAR(255) DEFAULT NULL, comments LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, uuid VARCHAR(255) DEFAULT NULL, INDEX IDX_B4D419573B69A9AF (variant_id), INDEX IDX_B4D419573207420A (purchase_order_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE purchase_order_item_variant ADD CONSTRAINT FK_B4D419573B69A9AF FOREIGN KEY (variant_id) REFERENCES product_variant (id)');
        $this->addSql('ALTER TABLE purchase_order_item_variant ADD CONSTRAINT FK_B4D419573207420A FOREIGN KEY (purchase_order_item_id) REFERENCES purchase_order_item (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE purchase_order_item_variant');
    }
}
