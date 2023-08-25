<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230825200532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frais_scolarites ADD frais_scolaires_id INT NOT NULL');
        $this->addSql('ALTER TABLE frais_scolarites ADD CONSTRAINT FK_B130BF49D031BFA8 FOREIGN KEY (frais_scolaires_id) REFERENCES frais_scolaires (id)');
        $this->addSql('CREATE INDEX IDX_B130BF49D031BFA8 ON frais_scolarites (frais_scolaires_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frais_scolarites DROP FOREIGN KEY FK_B130BF49D031BFA8');
        $this->addSql('DROP INDEX IDX_B130BF49D031BFA8 ON frais_scolarites');
        $this->addSql('ALTER TABLE frais_scolarites DROP frais_scolaires_id');
    }
}
