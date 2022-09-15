<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220915064446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE closing (id INT AUTO_INCREMENT NOT NULL, closed_by_id INT DEFAULT NULL, opened_by_id INT DEFAULT NULL, store_id INT DEFAULT NULL, date_from DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_to DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', closed_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', opening_balance DOUBLE PRECISION DEFAULT NULL, closing_balance DOUBLE PRECISION DEFAULT NULL, cash_added DOUBLE PRECISION DEFAULT NULL, cash_withdrawn DOUBLE PRECISION DEFAULT NULL, data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', denominations LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, uuid VARCHAR(255) DEFAULT NULL, INDEX IDX_5542EBB4E1FA7797 (closed_by_id), INDEX IDX_5542EBB4AB159F5 (opened_by_id), INDEX IDX_5542EBB4B092A811 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE closing ADD CONSTRAINT FK_5542EBB4E1FA7797 FOREIGN KEY (closed_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE closing ADD CONSTRAINT FK_5542EBB4AB159F5 FOREIGN KEY (opened_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE closing ADD CONSTRAINT FK_5542EBB4B092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF57587764D218E');
        $this->addSql('DROP INDEX IDX_FF57587764D218E ON store');
        $this->addSql('ALTER TABLE store ADD location VARCHAR(255) DEFAULT NULL, DROP location_id, CHANGE name name VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE closing');
        $this->addSql('ALTER TABLE store ADD location_id INT DEFAULT NULL, DROP location, CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF57587764D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('CREATE INDEX IDX_FF57587764D218E ON store (location_id)');
    }
}
