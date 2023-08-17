<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230817180036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frais_scolaires ADD statut_id INT NOT NULL');
        $this->addSql('ALTER TABLE frais_scolaires ADD CONSTRAINT FK_45A1720F6203804 FOREIGN KEY (statut_id) REFERENCES statuts (id)');
        $this->addSql('CREATE INDEX IDX_45A1720F6203804 ON frais_scolaires (statut_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frais_scolaires DROP FOREIGN KEY FK_45A1720F6203804');
        $this->addSql('DROP INDEX IDX_45A1720F6203804 ON frais_scolaires');
        $this->addSql('ALTER TABLE frais_scolaires DROP statut_id');
    }
}
