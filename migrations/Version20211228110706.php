<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211228110706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD is_active TINYINT(1) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE discount ADD is_active TINYINT(1) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP is_active, DROP created_at, DROP deleted_at, DROP updated_at');
        $this->addSql('ALTER TABLE discount DROP is_active, DROP created_at, DROP deleted_at, DROP updated_at');
    }
}
