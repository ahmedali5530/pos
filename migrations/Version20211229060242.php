<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211229060242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE is_active is_active TINYINT(1) DEFAULT \'1\'');
        $this->addSql('ALTER TABLE discount CHANGE is_active is_active TINYINT(1) DEFAULT \'1\'');
        $this->addSql('ALTER TABLE location CHANGE is_active is_active TINYINT(1) DEFAULT \'1\'');
        $this->addSql('ALTER TABLE product CHANGE is_active is_active TINYINT(1) DEFAULT \'1\'');
        $this->addSql('ALTER TABLE store CHANGE is_active is_active TINYINT(1) DEFAULT \'1\'');
        $this->addSql('ALTER TABLE tax CHANGE is_active is_active TINYINT(1) DEFAULT \'1\'');
        $this->addSql('ALTER TABLE user CHANGE is_active is_active TINYINT(1) DEFAULT \'1\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE is_active is_active TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE discount CHANGE is_active is_active TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE location CHANGE is_active is_active TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE is_active is_active TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE store CHANGE is_active is_active TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE tax CHANGE is_active is_active TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE is_active is_active TINYINT(1) DEFAULT NULL');
    }
}
