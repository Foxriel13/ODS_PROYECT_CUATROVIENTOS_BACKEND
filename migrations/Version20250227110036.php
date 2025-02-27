<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250227110036 extends AbstractMigration
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
        $this->addSql('CREATE TABLE iniciativas (id INT AUTO_INCREMENT NOT NULL, accion VARCHAR(255) DEFAULT NULL, horas INT NOT NULL, nombre VARCHAR(255) NOT NULL, producto_final VARCHAR(255) DEFAULT NULL, fecha_inicio DATE NOT NULL, fecha_fin DATE NOT NULL, eliminado TINYINT(1) NOT NULL, imagen VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE iniciativasmodulos (id INT AUTO_INCREMENT NOT NULL, iniciativa_id INT DEFAULT NULL, modulo_id INT DEFAULT NULL, INDEX IDX_DBF4FF47E16D9AB7 (iniciativa_id), INDEX IDX_DBF4FF47C07F55F5 (modulo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metas (id INT AUTO_INCREMENT NOT NULL, id_ods_id INT NOT NULL, descripcion VARCHAR(255) NOT NULL, INDEX IDX_4D6AF93CE26F6B1C (id_ods_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metasiniciativas (id INT AUTO_INCREMENT NOT NULL, cod_iniciativa_id INT DEFAULT NULL, id_metas_id INT DEFAULT NULL, INDEX IDX_E6045A769FF9454 (cod_iniciativa_id), INDEX IDX_E6045A7673F2E7AE (id_metas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modulos (id INT AUTO_INCREMENT NOT NULL, curso_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_D458AB5D87CB4A1F (curso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ods (id INT AUTO_INCREMENT NOT NULL, dimension_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_7457DB2A277428AD (dimension_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profesores (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profesoresiniciativas (id INT AUTO_INCREMENT NOT NULL, iniciativa_id INT DEFAULT NULL, profesor_id INT DEFAULT NULL, INDEX IDX_B944D47FE16D9AB7 (iniciativa_id), INDEX IDX_B944D47FE52BD977 (profesor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profesoresmodulos (id INT AUTO_INCREMENT NOT NULL, profesor_id INT DEFAULT NULL, modulos_id INT DEFAULT NULL, INDEX IDX_9BB3C0FCE52BD977 (profesor_id), INDEX IDX_9BB3C0FC2A66C4E3 (modulos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entidadesexternasiniciativas ADD CONSTRAINT FK_C681A29CE16D9AB7 FOREIGN KEY (iniciativa_id) REFERENCES iniciativas (id)');
        $this->addSql('ALTER TABLE entidadesexternasiniciativas ADD CONSTRAINT FK_C681A29C6CA204EF FOREIGN KEY (entidad_id) REFERENCES entidadesexternas (id)');
        $this->addSql('ALTER TABLE iniciativasmodulos ADD CONSTRAINT FK_DBF4FF47E16D9AB7 FOREIGN KEY (iniciativa_id) REFERENCES iniciativas (id)');
        $this->addSql('ALTER TABLE iniciativasmodulos ADD CONSTRAINT FK_DBF4FF47C07F55F5 FOREIGN KEY (modulo_id) REFERENCES modulos (id)');
        $this->addSql('ALTER TABLE metas ADD CONSTRAINT FK_4D6AF93CE26F6B1C FOREIGN KEY (id_ods_id) REFERENCES ods (id)');
        $this->addSql('ALTER TABLE metasiniciativas ADD CONSTRAINT FK_E6045A769FF9454 FOREIGN KEY (cod_iniciativa_id) REFERENCES iniciativas (id)');
        $this->addSql('ALTER TABLE metasiniciativas ADD CONSTRAINT FK_E6045A7673F2E7AE FOREIGN KEY (id_metas_id) REFERENCES metas (id)');
        $this->addSql('ALTER TABLE modulos ADD CONSTRAINT FK_D458AB5D87CB4A1F FOREIGN KEY (curso_id) REFERENCES cursos (id)');
        $this->addSql('ALTER TABLE ods ADD CONSTRAINT FK_7457DB2A277428AD FOREIGN KEY (dimension_id) REFERENCES dimension (id)');
        $this->addSql('ALTER TABLE profesoresiniciativas ADD CONSTRAINT FK_B944D47FE16D9AB7 FOREIGN KEY (iniciativa_id) REFERENCES iniciativas (id)');
        $this->addSql('ALTER TABLE profesoresiniciativas ADD CONSTRAINT FK_B944D47FE52BD977 FOREIGN KEY (profesor_id) REFERENCES profesores (id)');
        $this->addSql('ALTER TABLE profesoresmodulos ADD CONSTRAINT FK_9BB3C0FCE52BD977 FOREIGN KEY (profesor_id) REFERENCES profesores (id)');
        $this->addSql('ALTER TABLE profesoresmodulos ADD CONSTRAINT FK_9BB3C0FC2A66C4E3 FOREIGN KEY (modulos_id) REFERENCES modulos (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entidadesexternasiniciativas DROP FOREIGN KEY FK_C681A29CE16D9AB7');
        $this->addSql('ALTER TABLE entidadesexternasiniciativas DROP FOREIGN KEY FK_C681A29C6CA204EF');
        $this->addSql('ALTER TABLE iniciativasmodulos DROP FOREIGN KEY FK_DBF4FF47E16D9AB7');
        $this->addSql('ALTER TABLE iniciativasmodulos DROP FOREIGN KEY FK_DBF4FF47C07F55F5');
        $this->addSql('ALTER TABLE metas DROP FOREIGN KEY FK_4D6AF93CE26F6B1C');
        $this->addSql('ALTER TABLE metasiniciativas DROP FOREIGN KEY FK_E6045A769FF9454');
        $this->addSql('ALTER TABLE metasiniciativas DROP FOREIGN KEY FK_E6045A7673F2E7AE');
        $this->addSql('ALTER TABLE modulos DROP FOREIGN KEY FK_D458AB5D87CB4A1F');
        $this->addSql('ALTER TABLE ods DROP FOREIGN KEY FK_7457DB2A277428AD');
        $this->addSql('ALTER TABLE profesoresiniciativas DROP FOREIGN KEY FK_B944D47FE16D9AB7');
        $this->addSql('ALTER TABLE profesoresiniciativas DROP FOREIGN KEY FK_B944D47FE52BD977');
        $this->addSql('ALTER TABLE profesoresmodulos DROP FOREIGN KEY FK_9BB3C0FCE52BD977');
        $this->addSql('ALTER TABLE profesoresmodulos DROP FOREIGN KEY FK_9BB3C0FC2A66C4E3');
        $this->addSql('DROP TABLE cursos');
        $this->addSql('DROP TABLE dimension');
        $this->addSql('DROP TABLE entidadesexternas');
        $this->addSql('DROP TABLE entidadesexternasiniciativas');
        $this->addSql('DROP TABLE iniciativas');
        $this->addSql('DROP TABLE iniciativasmodulos');
        $this->addSql('DROP TABLE metas');
        $this->addSql('DROP TABLE metasiniciativas');
        $this->addSql('DROP TABLE modulos');
        $this->addSql('DROP TABLE ods');
        $this->addSql('DROP TABLE profesores');
        $this->addSql('DROP TABLE profesoresiniciativas');
        $this->addSql('DROP TABLE profesoresmodulos');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
