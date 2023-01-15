<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230115133644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medias ADD figures_id INT NOT NULL');
        $this->addSql('ALTER TABLE medias ADD CONSTRAINT FK_12D2AF815C7F3A37 FOREIGN KEY (figures_id) REFERENCES figure (id)');
        $this->addSql('CREATE INDEX IDX_12D2AF815C7F3A37 ON medias (figures_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medias DROP FOREIGN KEY FK_12D2AF815C7F3A37');
        $this->addSql('DROP INDEX IDX_12D2AF815C7F3A37 ON medias');
        $this->addSql('ALTER TABLE medias DROP figures_id');
    }
}
