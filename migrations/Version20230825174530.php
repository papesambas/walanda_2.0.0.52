<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230825174530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frais_scolaires ADD frais_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE frais_scolaires ADD CONSTRAINT FK_45A1720C8B377BF FOREIGN KEY (frais_type_id) REFERENCES frais_type (id)');
        $this->addSql('CREATE INDEX IDX_45A1720C8B377BF ON frais_scolaires (frais_type_id)');
        $this->addSql('ALTER TABLE frais_type ADD statut_id INT NOT NULL, ADD niveau_id INT NOT NULL');
        $this->addSql('ALTER TABLE frais_type ADD CONSTRAINT FK_7926F141F6203804 FOREIGN KEY (statut_id) REFERENCES statuts (id)');
        $this->addSql('ALTER TABLE frais_type ADD CONSTRAINT FK_7926F141B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveaux (id)');
        $this->addSql('CREATE INDEX IDX_7926F141F6203804 ON frais_type (statut_id)');
        $this->addSql('CREATE INDEX IDX_7926F141B3E9C81 ON frais_type (niveau_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE frais_scolaires DROP FOREIGN KEY FK_45A1720C8B377BF');
        $this->addSql('DROP INDEX IDX_45A1720C8B377BF ON frais_scolaires');
        $this->addSql('ALTER TABLE frais_scolaires DROP frais_type_id');
        $this->addSql('ALTER TABLE frais_type DROP FOREIGN KEY FK_7926F141F6203804');
        $this->addSql('ALTER TABLE frais_type DROP FOREIGN KEY FK_7926F141B3E9C81');
        $this->addSql('DROP INDEX IDX_7926F141F6203804 ON frais_type');
        $this->addSql('DROP INDEX IDX_7926F141B3E9C81 ON frais_type');
        $this->addSql('ALTER TABLE frais_type DROP statut_id, DROP niveau_id');
    }
}
