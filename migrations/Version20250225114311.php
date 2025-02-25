<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250225114311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dimension (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE iniciativasmodulos (id INT AUTO_INCREMENT NOT NULL, iniciativa_id INT DEFAULT NULL, modulo_id INT DEFAULT NULL, INDEX IDX_DBF4FF47E16D9AB7 (iniciativa_id), INDEX IDX_DBF4FF47C07F55F5 (modulo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE iniciativasmodulos ADD CONSTRAINT FK_DBF4FF47E16D9AB7 FOREIGN KEY (iniciativa_id) REFERENCES iniciativas (id)');
        $this->addSql('ALTER TABLE iniciativasmodulos ADD CONSTRAINT FK_DBF4FF47C07F55F5 FOREIGN KEY (modulo_id) REFERENCES modulos (id)');
        $this->addSql('ALTER TABLE ods ADD dimension_id INT DEFAULT NULL, DROP dimension');
        $this->addSql('ALTER TABLE ods ADD CONSTRAINT FK_7457DB2A277428AD FOREIGN KEY (dimension_id) REFERENCES dimension (id)');
        $this->addSql('CREATE INDEX IDX_7457DB2A277428AD ON ods (dimension_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ods DROP FOREIGN KEY FK_7457DB2A277428AD');
        $this->addSql('ALTER TABLE iniciativasmodulos DROP FOREIGN KEY FK_DBF4FF47E16D9AB7');
        $this->addSql('ALTER TABLE iniciativasmodulos DROP FOREIGN KEY FK_DBF4FF47C07F55F5');
        $this->addSql('DROP TABLE dimension');
        $this->addSql('DROP TABLE iniciativasmodulos');
        $this->addSql('DROP INDEX IDX_7457DB2A277428AD ON ods');
        $this->addSql('ALTER TABLE ods ADD dimension VARCHAR(255) DEFAULT NULL, DROP dimension_id');
    }
}
