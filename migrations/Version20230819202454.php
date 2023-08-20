<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230819202454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frais_scolarites_abandon ADD eleve_id INT NOT NULL, ADD inscription INT DEFAULT NULL, ADD carnet INT DEFAULT NULL, ADD transfert INT DEFAULT NULL, ADD septembre INT DEFAULT NULL, ADD octobre INT DEFAULT NULL, ADD novembre INT DEFAULT NULL, ADD decembre INT DEFAULT NULL, ADD janvier INT DEFAULT NULL, ADD fevrier INT DEFAULT NULL, ADD mars INT DEFAULT NULL, ADD avril INT DEFAULT NULL, ADD mai INT DEFAULT NULL, ADD juin INT DEFAULT NULL, ADD autre INT DEFAULT NULL, ADD arrieres INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE frais_scolarites_abandon ADD CONSTRAINT FK_30F19183A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleves (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_30F19183A6CC7B2 ON frais_scolarites_abandon (eleve_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frais_scolarites_abandon DROP FOREIGN KEY FK_30F19183A6CC7B2');
        $this->addSql('DROP INDEX UNIQ_30F19183A6CC7B2 ON frais_scolarites_abandon');
        $this->addSql('ALTER TABLE frais_scolarites_abandon DROP eleve_id, DROP inscription, DROP carnet, DROP transfert, DROP septembre, DROP octobre, DROP novembre, DROP decembre, DROP janvier, DROP fevrier, DROP mars, DROP avril, DROP mai, DROP juin, DROP autre, DROP arrieres, DROP created_at, DROP updated_at');
    }
}
