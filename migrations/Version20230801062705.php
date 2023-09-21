<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230801062705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE barcode (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, variant_id INT DEFAULT NULL, barcode VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, measurement VARCHAR(255) DEFAULT NULL, unit VARCHAR(255) DEFAULT NULL, INDEX IDX_97AE0266126F525E (item_id), INDEX IDX_97AE02663B69A9AF (variant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE barcode ADD CONSTRAINT FK_97AE0266126F525E FOREIGN KEY (item_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE barcode ADD CONSTRAINT FK_97AE02663B69A9AF FOREIGN KEY (variant_id) REFERENCES product_variant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE barcode');
    }
}
