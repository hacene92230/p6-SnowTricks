<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221231174405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE figure ADD groupe_id INT NOT NULL, ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37A7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE figure ADD CONSTRAINT FK_2F57B37AF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_2F57B37A7A45358C ON figure (groupe_id)');
        $this->addSql('CREATE INDEX IDX_2F57B37AF675F31B ON figure (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37A7A45358C');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('ALTER TABLE figure DROP FOREIGN KEY FK_2F57B37AF675F31B');
        $this->addSql('DROP INDEX IDX_2F57B37A7A45358C ON figure');
        $this->addSql('DROP INDEX IDX_2F57B37AF675F31B ON figure');
        $this->addSql('ALTER TABLE figure DROP groupe_id, DROP author_id');
    }
}
