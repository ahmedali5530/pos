<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220930173137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD department_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADAE80F5DF FOREIGN KEY (department_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADAE80F5DF ON product (department_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADAE80F5DF');
        $this->addSql('DROP INDEX IDX_D34A04ADAE80F5DF ON product');
        $this->addSql('ALTER TABLE product DROP department_id');
    }
}
