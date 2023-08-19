<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230817193807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE frais_scolarites (id INT AUTO_INCREMENT NOT NULL, eleve_id INT DEFAULT NULL, inscription INT DEFAULT NULL, carnet INT DEFAULT NULL, transfert INT DEFAULT NULL, septembre INT DEFAULT NULL, octobre INT DEFAULT NULL, novembre INT DEFAULT NULL, decembre INT DEFAULT NULL, janvier INT DEFAULT NULL, fevrier INT DEFAULT NULL, mars INT DEFAULT NULL, avril INT DEFAULT NULL, mai INT DEFAULT NULL, juin INT DEFAULT NULL, autre INT DEFAULT NULL, UNIQUE INDEX UNIQ_B130BF49A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE frais_scolarites ADD CONSTRAINT FK_B130BF49A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleves (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frais_scolarites DROP FOREIGN KEY FK_B130BF49A6CC7B2');
        $this->addSql('DROP TABLE frais_scolarites');
    }
}
