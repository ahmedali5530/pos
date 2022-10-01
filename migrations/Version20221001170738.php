<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221001170738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_terminal (product_id INT NOT NULL, terminal_id INT NOT NULL, INDEX IDX_44CB7FD64584665A (product_id), INDEX IDX_44CB7FD6E77B6CE8 (terminal_id), PRIMARY KEY(product_id, terminal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_terminal ADD CONSTRAINT FK_44CB7FD64584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_terminal ADD CONSTRAINT FK_44CB7FD6E77B6CE8 FOREIGN KEY (terminal_id) REFERENCES terminal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE closing ADD terminal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE closing ADD CONSTRAINT FK_5542EBB4E77B6CE8 FOREIGN KEY (terminal_id) REFERENCES terminal (id)');
        $this->addSql('CREATE INDEX IDX_5542EBB4E77B6CE8 ON closing (terminal_id)');
        $this->addSql('ALTER TABLE `order` ADD terminal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398E77B6CE8 FOREIGN KEY (terminal_id) REFERENCES terminal (id)');
        $this->addSql('CREATE INDEX IDX_F5299398E77B6CE8 ON `order` (terminal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE product_terminal');
        $this->addSql('ALTER TABLE closing DROP FOREIGN KEY FK_5542EBB4E77B6CE8');
        $this->addSql('DROP INDEX IDX_5542EBB4E77B6CE8 ON closing');
        $this->addSql('ALTER TABLE closing DROP terminal_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398E77B6CE8');
        $this->addSql('DROP INDEX IDX_F5299398E77B6CE8 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP terminal_id');
    }
}
