<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220423163019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer_payment (id INT AUTO_INCREMENT NOT NULL, orde_id INT DEFAULT NULL, customer_id INT NOT NULL, amount NUMERIC(10, 2) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, uuid VARCHAR(255) DEFAULT NULL, INDEX IDX_71F520B35F328526 (orde_id), INDEX IDX_71F520B39395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer_payment ADD CONSTRAINT FK_71F520B35F328526 FOREIGN KEY (orde_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE customer_payment ADD CONSTRAINT FK_71F520B39395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE customer_payment');
    }
}
