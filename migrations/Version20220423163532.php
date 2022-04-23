<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220423163532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer_payment DROP FOREIGN KEY FK_71F520B35F328526');
        $this->addSql('DROP INDEX IDX_71F520B35F328526 ON customer_payment');
        $this->addSql('ALTER TABLE customer_payment CHANGE orde_id order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customer_payment ADD CONSTRAINT FK_71F520B38D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_71F520B38D9F6D38 ON customer_payment (order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer_payment DROP FOREIGN KEY FK_71F520B38D9F6D38');
        $this->addSql('DROP INDEX IDX_71F520B38D9F6D38 ON customer_payment');
        $this->addSql('ALTER TABLE customer_payment CHANGE order_id orde_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE customer_payment ADD CONSTRAINT FK_71F520B35F328526 FOREIGN KEY (orde_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_71F520B35F328526 ON customer_payment (orde_id)');
    }
}
