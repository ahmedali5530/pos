<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221021074541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_product_tax (order_product_id INT NOT NULL, tax_id INT NOT NULL, INDEX IDX_751C91EFF65E9B0F (order_product_id), INDEX IDX_751C91EFB2A824D8 (tax_id), PRIMARY KEY(order_product_id, tax_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_product_tax ADD CONSTRAINT FK_751C91EFF65E9B0F FOREIGN KEY (order_product_id) REFERENCES order_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_product_tax ADD CONSTRAINT FK_751C91EFB2A824D8 FOREIGN KEY (tax_id) REFERENCES tax (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE order_product_tax');
    }
}
