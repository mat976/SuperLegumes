<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241123041541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission ADD assigned_team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C23F46021 FOREIGN KEY (assigned_team_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_9067F23C23F46021 ON mission (assigned_team_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C23F46021');
        $this->addSql('DROP INDEX IDX_9067F23C23F46021 ON mission');
        $this->addSql('ALTER TABLE mission DROP assigned_team_id');
    }
}
