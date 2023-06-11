<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230521072152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE supplier_payment (id INT AUTO_INCREMENT NOT NULL, purchase_id INT DEFAULT NULL, supplier_id INT NOT NULL, amount NUMERIC(10, 2) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_EC4DF012558FBEB9 (purchase_id), INDEX IDX_EC4DF0122ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE supplier_payment ADD CONSTRAINT FK_EC4DF012558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id)');
        $this->addSql('ALTER TABLE supplier_payment ADD CONSTRAINT FK_EC4DF0122ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('ALTER TABLE purchase ADD payment_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BDC058279 FOREIGN KEY (payment_type_id) REFERENCES payment (id)');
        $this->addSql('CREATE INDEX IDX_6117D13BDC058279 ON purchase (payment_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE supplier_payment');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13BDC058279');
        $this->addSql('DROP INDEX IDX_6117D13BDC058279 ON purchase');
        $this->addSql('ALTER TABLE purchase DROP payment_type_id');
    }
}
