<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230819131829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_45C1718D8947610D ON cercles (designation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2ED7EC58947610D ON classes (designation)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_45C1718D8947610D ON cercles');
        $this->addSql('DROP INDEX UNIQ_2ED7EC58947610D ON classes');
    }
}
