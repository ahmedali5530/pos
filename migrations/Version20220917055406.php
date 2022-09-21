<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220917055406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand_store (brand_id INT NOT NULL, store_id INT NOT NULL, INDEX IDX_A4AE916044F5D008 (brand_id), INDEX IDX_A4AE9160B092A811 (store_id), PRIMARY KEY(brand_id, store_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_store (category_id INT NOT NULL, store_id INT NOT NULL, INDEX IDX_1764173E12469DE2 (category_id), INDEX IDX_1764173EB092A811 (store_id), PRIMARY KEY(category_id, store_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discount_store (discount_id INT NOT NULL, store_id INT NOT NULL, INDEX IDX_D47D80E04C7C611F (discount_id), INDEX IDX_D47D80E0B092A811 (store_id), PRIMARY KEY(discount_id, store_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_store (payment_id INT NOT NULL, store_id INT NOT NULL, INDEX IDX_A81E6EC54C3A3BB (payment_id), INDEX IDX_A81E6EC5B092A811 (store_id), PRIMARY KEY(payment_id, store_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_store (product_id INT NOT NULL, store_id INT NOT NULL, INDEX IDX_5E0B232B4584665A (product_id), INDEX IDX_5E0B232BB092A811 (store_id), PRIMARY KEY(product_id, store_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE supplier_store (supplier_id INT NOT NULL, store_id INT NOT NULL, INDEX IDX_264C5A5D2ADD6D8C (supplier_id), INDEX IDX_264C5A5DB092A811 (store_id), PRIMARY KEY(supplier_id, store_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tax_store (tax_id INT NOT NULL, store_id INT NOT NULL, INDEX IDX_4C2DAD56B2A824D8 (tax_id), INDEX IDX_4C2DAD56B092A811 (store_id), PRIMARY KEY(tax_id, store_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brand_store ADD CONSTRAINT FK_A4AE916044F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brand_store ADD CONSTRAINT FK_A4AE9160B092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_store ADD CONSTRAINT FK_1764173E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_store ADD CONSTRAINT FK_1764173EB092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discount_store ADD CONSTRAINT FK_D47D80E04C7C611F FOREIGN KEY (discount_id) REFERENCES discount (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discount_store ADD CONSTRAINT FK_D47D80E0B092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE payment_store ADD CONSTRAINT FK_A81E6EC54C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE payment_store ADD CONSTRAINT FK_A81E6EC5B092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_store ADD CONSTRAINT FK_5E0B232B4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_store ADD CONSTRAINT FK_5E0B232BB092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE supplier_store ADD CONSTRAINT FK_264C5A5D2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE supplier_store ADD CONSTRAINT FK_264C5A5DB092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tax_store ADD CONSTRAINT FK_4C2DAD56B2A824D8 FOREIGN KEY (tax_id) REFERENCES tax (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tax_store ADD CONSTRAINT FK_4C2DAD56B092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE expense ADD store_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA6B092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('CREATE INDEX IDX_2D3A8DA6B092A811 ON expense (store_id)');
        $this->addSql('ALTER TABLE `order` ADD store_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398B092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('CREATE INDEX IDX_F5299398B092A811 ON `order` (store_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE brand_store');
        $this->addSql('DROP TABLE category_store');
        $this->addSql('DROP TABLE discount_store');
        $this->addSql('DROP TABLE payment_store');
        $this->addSql('DROP TABLE product_store');
        $this->addSql('DROP TABLE supplier_store');
        $this->addSql('DROP TABLE tax_store');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA6B092A811');
        $this->addSql('DROP INDEX IDX_2D3A8DA6B092A811 ON expense');
        $this->addSql('ALTER TABLE expense DROP store_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398B092A811');
        $this->addSql('DROP INDEX IDX_F5299398B092A811 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP store_id');
    }
}
