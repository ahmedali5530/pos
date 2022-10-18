<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221014050857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
//        $this->addSql('ALTER TABLE closing DROP FOREIGN KEY FK_5542EBB4AB159F5');
//        $this->addSql('ALTER TABLE closing DROP FOREIGN KEY FK_5542EBB4E1FA7797');
//        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA6A76ED395');
//        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
//        $this->addSql('ALTER TABLE setting DROP FOREIGN KEY FK_9F74B898A76ED395');
//        $this->addSql('ALTER TABLE user_store DROP FOREIGN KEY FK_1D95A32FA76ED395');
//        $this->addSql('CREATE TABLE product_tax (product_id INT NOT NULL, tax_id INT NOT NULL, INDEX IDX_6EAEEE694584665A (product_id), INDEX IDX_6EAEEE69B2A824D8 (tax_id), PRIMARY KEY(product_id, tax_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
//        $this->addSql('CREATE TABLE user_account (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, salt VARCHAR(255) NOT NULL, display_name VARCHAR(255) NOT NULL, verification_token VARCHAR(255) DEFAULT NULL, password_reset_token VARCHAR(255) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', email VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) DEFAULT \'1\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, uuid VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
//        $this->addSql('ALTER TABLE product_tax ADD CONSTRAINT FK_6EAEEE694584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
//        $this->addSql('ALTER TABLE product_tax ADD CONSTRAINT FK_6EAEEE69B2A824D8 FOREIGN KEY (tax_id) REFERENCES tax (id) ON DELETE CASCADE');
//        $this->addSql('DROP TABLE user');
//        $this->addSql('ALTER TABLE closing DROP FOREIGN KEY FK_5542EBB4AB159F5');
//        $this->addSql('ALTER TABLE closing DROP FOREIGN KEY FK_5542EBB4E1FA7797');
        $this->addSql('ALTER TABLE closing ADD CONSTRAINT FK_5542EBB4AB159F5 FOREIGN KEY (opened_by_id) REFERENCES user_account (id)');
        $this->addSql('ALTER TABLE closing ADD CONSTRAINT FK_5542EBB4E1FA7797 FOREIGN KEY (closed_by_id) REFERENCES user_account (id)');
//        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA6A76ED395');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA6A76ED395 FOREIGN KEY (user_id) REFERENCES user_account (id)');
//        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user_account (id)');
        $this->addSql('ALTER TABLE product_variant CHANGE attribute_value attribute_value VARCHAR(255) DEFAULT NULL');
//        $this->addSql('ALTER TABLE setting DROP FOREIGN KEY FK_9F74B898A76ED395');
        $this->addSql('ALTER TABLE setting ADD CONSTRAINT FK_9F74B898A76ED395 FOREIGN KEY (user_id) REFERENCES user_account (id)');
//        $this->addSql('ALTER TABLE user_store DROP FOREIGN KEY FK_1D95A32FA76ED395');
        $this->addSql('ALTER TABLE user_store ADD CONSTRAINT FK_1D95A32FA76ED395 FOREIGN KEY (user_id) REFERENCES user_account (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE closing DROP FOREIGN KEY FK_5542EBB4E1FA7797');
        $this->addSql('ALTER TABLE closing DROP FOREIGN KEY FK_5542EBB4AB159F5');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA6A76ED395');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE setting DROP FOREIGN KEY FK_9F74B898A76ED395');
        $this->addSql('ALTER TABLE user_store DROP FOREIGN KEY FK_1D95A32FA76ED395');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, salt VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, display_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, verification_token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, password_reset_token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', is_active TINYINT(1) DEFAULT \'1\', created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', deleted_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, uuid VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE product_tax');
        $this->addSql('DROP TABLE user_account');
        $this->addSql('ALTER TABLE closing DROP FOREIGN KEY FK_5542EBB4E1FA7797');
        $this->addSql('ALTER TABLE closing DROP FOREIGN KEY FK_5542EBB4AB159F5');
        $this->addSql('ALTER TABLE closing ADD CONSTRAINT FK_5542EBB4E1FA7797 FOREIGN KEY (closed_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE closing ADD CONSTRAINT FK_5542EBB4AB159F5 FOREIGN KEY (opened_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA6A76ED395');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product_variant CHANGE attribute_value attribute_value VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE setting DROP FOREIGN KEY FK_9F74B898A76ED395');
        $this->addSql('ALTER TABLE setting ADD CONSTRAINT FK_9F74B898A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_store DROP FOREIGN KEY FK_1D95A32FA76ED395');
        $this->addSql('ALTER TABLE user_store ADD CONSTRAINT FK_1D95A32FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }
}
