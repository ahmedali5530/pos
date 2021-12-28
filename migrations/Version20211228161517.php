<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211228161517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE customer ADD uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE discount ADD uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE location ADD uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE store ADD uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tax ADD uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD uuid VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP uuid');
        $this->addSql('ALTER TABLE customer DROP uuid');
        $this->addSql('ALTER TABLE discount DROP uuid');
        $this->addSql('ALTER TABLE location DROP uuid');
        $this->addSql('ALTER TABLE `order` DROP uuid');
        $this->addSql('ALTER TABLE product DROP uuid');
        $this->addSql('ALTER TABLE store DROP uuid');
        $this->addSql('ALTER TABLE tax DROP uuid');
        $this->addSql('ALTER TABLE user DROP uuid');
    }
}
