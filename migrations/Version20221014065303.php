<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221014065303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_inventory (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, entity VARCHAR(255) DEFAULT NULL, entity_type VARCHAR(255) DEFAULT NULL, INDEX IDX_DF8DFCBB4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_inventory ADD CONSTRAINT FK_DF8DFCBB4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product ADD manage_inventory TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product_inventory');
        $this->addSql('ALTER TABLE product DROP manage_inventory');
    }
}
