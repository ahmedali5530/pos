<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220215161833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_payment ADD type_id INT DEFAULT NULL, DROP type');
        $this->addSql('ALTER TABLE order_payment ADD CONSTRAINT FK_9B522D46C54C8C93 FOREIGN KEY (type_id) REFERENCES payment (id)');
        $this->addSql('CREATE INDEX IDX_9B522D46C54C8C93 ON order_payment (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_payment DROP FOREIGN KEY FK_9B522D46C54C8C93');
        $this->addSql('DROP INDEX IDX_9B522D46C54C8C93 ON order_payment');
        $this->addSql('ALTER TABLE order_payment ADD type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP type_id');
    }
}
