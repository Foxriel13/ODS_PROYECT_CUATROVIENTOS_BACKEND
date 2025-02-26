<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250226084928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cursos (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dimension (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entidadesexternas (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entidadesexternasiniciativas (id INT AUTO_INCREMENT NOT NULL, iniciativa_id INT DEFAULT NULL, entidad_id INT DEFAULT NULL, INDEX IDX_C681A29CE16D9AB7 (iniciativa_id), INDEX IDX_C681A29C6CA204EF (entidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE iniciativasmodulos (id INT AUTO_INCREMENT NOT NULL, iniciativa_id INT DEFAULT NULL, modulo_id INT DEFAULT NULL, INDEX IDX_DBF4FF47E16D9AB7 (iniciativa_id), INDEX IDX_DBF4FF47C07F55F5 (modulo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modulos (id INT AUTO_INCREMENT NOT NULL, curso_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_D458AB5D87CB4A1F (curso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profesores (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profesoresiniciativas (id INT AUTO_INCREMENT NOT NULL, iniciativa_id INT NOT NULL, trabajador_id INT NOT NULL, INDEX IDX_B944D47FE16D9AB7 (iniciativa_id), INDEX IDX_B944D47FEC3656E (trabajador_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entidadesexternasiniciativas ADD CONSTRAINT FK_C681A29CE16D9AB7 FOREIGN KEY (iniciativa_id) REFERENCES iniciativas (id)');
        $this->addSql('ALTER TABLE entidadesexternasiniciativas ADD CONSTRAINT FK_C681A29C6CA204EF FOREIGN KEY (entidad_id) REFERENCES entidadesexternas (id)');
        $this->addSql('ALTER TABLE iniciativasmodulos ADD CONSTRAINT FK_DBF4FF47E16D9AB7 FOREIGN KEY (iniciativa_id) REFERENCES iniciativas (id)');
        $this->addSql('ALTER TABLE iniciativasmodulos ADD CONSTRAINT FK_DBF4FF47C07F55F5 FOREIGN KEY (modulo_id) REFERENCES modulos (id)');
        $this->addSql('ALTER TABLE modulos ADD CONSTRAINT FK_D458AB5D87CB4A1F FOREIGN KEY (curso_id) REFERENCES cursos (id)');
        $this->addSql('ALTER TABLE profesoresiniciativas ADD CONSTRAINT FK_B944D47FE16D9AB7 FOREIGN KEY (iniciativa_id) REFERENCES iniciativas (id)');
        $this->addSql('ALTER TABLE profesoresiniciativas ADD CONSTRAINT FK_B944D47FEC3656E FOREIGN KEY (trabajador_id) REFERENCES profesores (id)');
        $this->addSql('ALTER TABLE metasiniciativas DROP FOREIGN KEY FK_E6045A76E26F6B1C');
        $this->addSql('DROP INDEX IDX_E6045A76E26F6B1C ON metasiniciativas');
        $this->addSql('ALTER TABLE metasiniciativas DROP id_ods_id');
        $this->addSql('ALTER TABLE ods ADD dimension_id INT DEFAULT NULL, DROP dimension');
        $this->addSql('ALTER TABLE ods ADD CONSTRAINT FK_7457DB2A277428AD FOREIGN KEY (dimension_id) REFERENCES dimension (id)');
        $this->addSql('CREATE INDEX IDX_7457DB2A277428AD ON ods (dimension_id)');
        $this->addSql('ALTER TABLE profesoresmodulos ADD CONSTRAINT FK_9BB3C0FCE52BD977 FOREIGN KEY (profesor_id) REFERENCES profesores (id)');
        $this->addSql('ALTER TABLE profesoresmodulos ADD CONSTRAINT FK_9BB3C0FC2A66C4E3 FOREIGN KEY (modulos_id) REFERENCES modulos (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ods DROP FOREIGN KEY FK_7457DB2A277428AD');
        $this->addSql('ALTER TABLE profesoresmodulos DROP FOREIGN KEY FK_9BB3C0FC2A66C4E3');
        $this->addSql('ALTER TABLE profesoresmodulos DROP FOREIGN KEY FK_9BB3C0FCE52BD977');
        $this->addSql('ALTER TABLE entidadesexternasiniciativas DROP FOREIGN KEY FK_C681A29CE16D9AB7');
        $this->addSql('ALTER TABLE entidadesexternasiniciativas DROP FOREIGN KEY FK_C681A29C6CA204EF');
        $this->addSql('ALTER TABLE iniciativasmodulos DROP FOREIGN KEY FK_DBF4FF47E16D9AB7');
        $this->addSql('ALTER TABLE iniciativasmodulos DROP FOREIGN KEY FK_DBF4FF47C07F55F5');
        $this->addSql('ALTER TABLE modulos DROP FOREIGN KEY FK_D458AB5D87CB4A1F');
        $this->addSql('ALTER TABLE profesoresiniciativas DROP FOREIGN KEY FK_B944D47FE16D9AB7');
        $this->addSql('ALTER TABLE profesoresiniciativas DROP FOREIGN KEY FK_B944D47FEC3656E');
        $this->addSql('DROP TABLE cursos');
        $this->addSql('DROP TABLE dimension');
        $this->addSql('DROP TABLE entidadesexternas');
        $this->addSql('DROP TABLE entidadesexternasiniciativas');
        $this->addSql('DROP TABLE iniciativasmodulos');
        $this->addSql('DROP TABLE modulos');
        $this->addSql('DROP TABLE profesores');
        $this->addSql('DROP TABLE profesoresiniciativas');
        $this->addSql('ALTER TABLE metasiniciativas ADD id_ods_id INT NOT NULL');
        $this->addSql('ALTER TABLE metasiniciativas ADD CONSTRAINT FK_E6045A76E26F6B1C FOREIGN KEY (id_ods_id) REFERENCES metas (id)');
        $this->addSql('CREATE INDEX IDX_E6045A76E26F6B1C ON metasiniciativas (id_ods_id)');
        $this->addSql('DROP INDEX IDX_7457DB2A277428AD ON ods');
        $this->addSql('ALTER TABLE ods ADD dimension VARCHAR(255) DEFAULT NULL, DROP dimension_id');
    }
}
