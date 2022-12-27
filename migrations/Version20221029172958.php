<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221029172958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order_product` DROP FOREIGN KEY `FK_2530ADE63B69A9AF`');
        $this->addSql('ALTER TABLE `order_product` ADD CONSTRAINT `FK_2530ADE63B69A9AF` FOREIGN KEY (`variant_id`) REFERENCES `product_variant`(`id`) ON DELETE RESTRICT ON UPDATE NO ACTION;');
        $this->addSql('ALTER TABLE `order_product` DROP FOREIGN KEY `FK_2530ADE6FA237437`');
        $this->addSql('ALTER TABLE `order_product` ADD CONSTRAINT `FK_2530ADE6FA237437` FOREIGN KEY (`orderId`) REFERENCES `order`(`id`) ON DELETE RESTRICT ON UPDATE NO ACTION');
    }

    public function down(Schema $schema): void
    {

    }
}
