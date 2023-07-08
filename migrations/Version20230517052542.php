<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230517052542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE purchase_item_variant (id INT AUTO_INCREMENT NOT NULL, variant_id INT NOT NULL, purchase_item_id INT NOT NULL, quantity NUMERIC(10, 2) NOT NULL, purchase_price NUMERIC(10, 2) NOT NULL, purchase_unit VARCHAR(255) DEFAULT NULL, barcode VARCHAR(255) DEFAULT NULL, comments LONGTEXT DEFAULT NULL, INDEX IDX_3E046E593B69A9AF (variant_id), INDEX IDX_3E046E599B59827 (purchase_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE purchase_item_variant ADD CONSTRAINT FK_3E046E593B69A9AF FOREIGN KEY (variant_id) REFERENCES product_variant (id)');
        $this->addSql('ALTER TABLE purchase_item_variant ADD CONSTRAINT FK_3E046E599B59827 FOREIGN KEY (purchase_item_id) REFERENCES purchase_item (id)');
        $this->addSql('ALTER TABLE purchase_item CHANGE purchase_unit purchase_unit VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE purchase_item_variant');
        $this->addSql('ALTER TABLE purchase_item CHANGE purchase_unit purchase_unit VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
