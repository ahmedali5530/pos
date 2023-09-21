<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230805073153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_discount DROP FOREIGN KEY FK_1856BFC54C8C93');
        $this->addSql('ALTER TABLE order_discount ADD CONSTRAINT FK_1856BFC54C8C93 FOREIGN KEY (type_id) REFERENCES discount (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_discount DROP FOREIGN KEY FK_1856BFC54C8C93');
        $this->addSql('ALTER TABLE order_discount ADD CONSTRAINT FK_1856BFC54C8C93 FOREIGN KEY (type_id) REFERENCES discount (id)');
    }
}
