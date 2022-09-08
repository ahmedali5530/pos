<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220908074951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE device ADD uuid VARCHAR(255) DEFAULT NULL, CHANGE prints prints INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE product_price ADD uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_variant ADD uuid VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE device DROP uuid, CHANGE prints prints INT NOT NULL');
        $this->addSql('ALTER TABLE product_price DROP uuid');
        $this->addSql('ALTER TABLE product_variant DROP uuid');
    }
}
