<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250325130011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clase (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entidad_externa (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entidad_externa_iniciativa (id INT AUTO_INCREMENT NOT NULL, iniciativa_id INT DEFAULT NULL, entidad_id INT DEFAULT NULL, INDEX IDX_52D1EDCFE16D9AB7 (iniciativa_id), INDEX IDX_52D1EDCF6CA204EF (entidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE iniciativa (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(255) DEFAULT NULL, horas INT NOT NULL, nombre VARCHAR(255) NOT NULL, explicacion VARCHAR(255) DEFAULT NULL, fecha_inicio DATE NOT NULL, fecha_fin DATE NOT NULL, eliminado TINYINT(1) NOT NULL, imagen VARCHAR(255) DEFAULT NULL, fecha_registro DATE NOT NULL, innovador TINYINT(1) NOT NULL, anyo_lectivo VARCHAR(255) DEFAULT NULL, mas_comentarios VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE iniciativa_modulo (id INT AUTO_INCREMENT NOT NULL, iniciativa_id INT DEFAULT NULL, modulo_id INT DEFAULT NULL, INDEX IDX_4841B297E16D9AB7 (iniciativa_id), INDEX IDX_4841B297C07F55F5 (modulo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE iniciativa_redes_sociales (id INT AUTO_INCREMENT NOT NULL, iniciativa_id INT DEFAULT NULL, redes_sociales_id INT DEFAULT NULL, INDEX IDX_51A31978E16D9AB7 (iniciativa_id), INDEX IDX_51A31978BD5BE588 (redes_sociales_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meta (id INT AUTO_INCREMENT NOT NULL, ods_id INT NOT NULL, descripcion VARCHAR(255) NOT NULL, INDEX IDX_D7F21435C458DEF1 (ods_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meta_iniciativa (id INT AUTO_INCREMENT NOT NULL, cod_iniciativa_id INT DEFAULT NULL, id_metas_id INT DEFAULT NULL, INDEX IDX_E4EA1A0A9FF9454 (cod_iniciativa_id), INDEX IDX_E4EA1A0A73F2E7AE (id_metas_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modulo (id INT AUTO_INCREMENT NOT NULL, clase_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_ECF1CF369F720353 (clase_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ods (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, dimension VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profesor (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profesor_iniciativa (id INT AUTO_INCREMENT NOT NULL, iniciativa_id INT DEFAULT NULL, profesor_id INT DEFAULT NULL, INDEX IDX_FB4593EFE16D9AB7 (iniciativa_id), INDEX IDX_FB4593EFE52BD977 (profesor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE redes_sociales (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, enlace VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entidad_externa_iniciativa ADD CONSTRAINT FK_52D1EDCFE16D9AB7 FOREIGN KEY (iniciativa_id) REFERENCES iniciativa (id)');
        $this->addSql('ALTER TABLE entidad_externa_iniciativa ADD CONSTRAINT FK_52D1EDCF6CA204EF FOREIGN KEY (entidad_id) REFERENCES entidad_externa (id)');
        $this->addSql('ALTER TABLE iniciativa_modulo ADD CONSTRAINT FK_4841B297E16D9AB7 FOREIGN KEY (iniciativa_id) REFERENCES iniciativa (id)');
        $this->addSql('ALTER TABLE iniciativa_modulo ADD CONSTRAINT FK_4841B297C07F55F5 FOREIGN KEY (modulo_id) REFERENCES modulo (id)');
        $this->addSql('ALTER TABLE iniciativa_redes_sociales ADD CONSTRAINT FK_51A31978E16D9AB7 FOREIGN KEY (iniciativa_id) REFERENCES iniciativa (id)');
        $this->addSql('ALTER TABLE iniciativa_redes_sociales ADD CONSTRAINT FK_51A31978BD5BE588 FOREIGN KEY (redes_sociales_id) REFERENCES redes_sociales (id)');
        $this->addSql('ALTER TABLE meta ADD CONSTRAINT FK_D7F21435C458DEF1 FOREIGN KEY (ods_id) REFERENCES ods (id)');
        $this->addSql('ALTER TABLE meta_iniciativa ADD CONSTRAINT FK_E4EA1A0A9FF9454 FOREIGN KEY (cod_iniciativa_id) REFERENCES iniciativa (id)');
        $this->addSql('ALTER TABLE meta_iniciativa ADD CONSTRAINT FK_E4EA1A0A73F2E7AE FOREIGN KEY (id_metas_id) REFERENCES meta (id)');
        $this->addSql('ALTER TABLE modulo ADD CONSTRAINT FK_ECF1CF369F720353 FOREIGN KEY (clase_id) REFERENCES clase (id)');
        $this->addSql('ALTER TABLE profesor_iniciativa ADD CONSTRAINT FK_FB4593EFE16D9AB7 FOREIGN KEY (iniciativa_id) REFERENCES iniciativa (id)');
        $this->addSql('ALTER TABLE profesor_iniciativa ADD CONSTRAINT FK_FB4593EFE52BD977 FOREIGN KEY (profesor_id) REFERENCES profesor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entidad_externa_iniciativa DROP FOREIGN KEY FK_52D1EDCFE16D9AB7');
        $this->addSql('ALTER TABLE entidad_externa_iniciativa DROP FOREIGN KEY FK_52D1EDCF6CA204EF');
        $this->addSql('ALTER TABLE iniciativa_modulo DROP FOREIGN KEY FK_4841B297E16D9AB7');
        $this->addSql('ALTER TABLE iniciativa_modulo DROP FOREIGN KEY FK_4841B297C07F55F5');
        $this->addSql('ALTER TABLE iniciativa_redes_sociales DROP FOREIGN KEY FK_51A31978E16D9AB7');
        $this->addSql('ALTER TABLE iniciativa_redes_sociales DROP FOREIGN KEY FK_51A31978BD5BE588');
        $this->addSql('ALTER TABLE meta DROP FOREIGN KEY FK_D7F21435C458DEF1');
        $this->addSql('ALTER TABLE meta_iniciativa DROP FOREIGN KEY FK_E4EA1A0A9FF9454');
        $this->addSql('ALTER TABLE meta_iniciativa DROP FOREIGN KEY FK_E4EA1A0A73F2E7AE');
        $this->addSql('ALTER TABLE modulo DROP FOREIGN KEY FK_ECF1CF369F720353');
        $this->addSql('ALTER TABLE profesor_iniciativa DROP FOREIGN KEY FK_FB4593EFE16D9AB7');
        $this->addSql('ALTER TABLE profesor_iniciativa DROP FOREIGN KEY FK_FB4593EFE52BD977');
        $this->addSql('DROP TABLE clase');
        $this->addSql('DROP TABLE entidad_externa');
        $this->addSql('DROP TABLE entidad_externa_iniciativa');
        $this->addSql('DROP TABLE iniciativa');
        $this->addSql('DROP TABLE iniciativa_modulo');
        $this->addSql('DROP TABLE iniciativa_redes_sociales');
        $this->addSql('DROP TABLE meta');
        $this->addSql('DROP TABLE meta_iniciativa');
        $this->addSql('DROP TABLE modulo');
        $this->addSql('DROP TABLE ods');
        $this->addSql('DROP TABLE profesor');
        $this->addSql('DROP TABLE profesor_iniciativa');
        $this->addSql('DROP TABLE redes_sociales');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
