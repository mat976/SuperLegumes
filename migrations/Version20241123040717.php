<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241123040717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission_team DROP FOREIGN KEY FK_EDA20A10296CD8AE');
        $this->addSql('ALTER TABLE mission_team DROP FOREIGN KEY FK_EDA20A10BE6CAE90');
        $this->addSql('DROP TABLE mission_team');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mission_team (mission_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_EDA20A10BE6CAE90 (mission_id), INDEX IDX_EDA20A10296CD8AE (team_id), PRIMARY KEY(mission_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE mission_team ADD CONSTRAINT FK_EDA20A10296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_team ADD CONSTRAINT FK_EDA20A10BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
