<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307070611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE purchase ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE purchase_item ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE purchase_order ADD store_id INT NOT NULL, ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE purchase_order ADD CONSTRAINT FK_21E210B2B092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('CREATE INDEX IDX_21E210B2B092A811 ON purchase_order (store_id)');
        $this->addSql('ALTER TABLE purchase_order_item ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD deleted_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD uuid VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE purchase DROP deleted_at, DROP updated_at, DROP uuid');
        $this->addSql('ALTER TABLE purchase_item DROP created_at, DROP deleted_at, DROP updated_at, DROP uuid');
        $this->addSql('ALTER TABLE purchase_order DROP FOREIGN KEY FK_21E210B2B092A811');
        $this->addSql('DROP INDEX IDX_21E210B2B092A811 ON purchase_order');
        $this->addSql('ALTER TABLE purchase_order DROP store_id, DROP deleted_at, DROP updated_at, DROP uuid');
        $this->addSql('ALTER TABLE purchase_order_item DROP created_at, DROP deleted_at, DROP updated_at, DROP uuid');
    }
}
