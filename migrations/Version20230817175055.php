<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230817175055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE frais_scolaires (id INT AUTO_INCREMENT NOT NULL, niveau_id INT NOT NULL, frais_inscription INT DEFAULT NULL, frais_carnet INT DEFAULT NULL, frais_transfert INT DEFAULT NULL, septembre INT DEFAULT NULL, octobre INT NOT NULL, novembre INT NOT NULL, decembre INT NOT NULL, janvier INT NOT NULL, fevrier INT NOT NULL, mars INT NOT NULL, avril INT NOT NULL, mai INT NOT NULL, juin INT DEFAULT NULL, autres INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_45A1720B3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE frais_scolaires ADD CONSTRAINT FK_45A1720B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveaux (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frais_scolaires DROP FOREIGN KEY FK_45A1720B3E9C81');
        $this->addSql('DROP TABLE frais_scolaires');
    }
}
