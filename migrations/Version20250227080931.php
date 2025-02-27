<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250227080931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entidadesexternasiniciativas DROP FOREIGN KEY FK_C681A29CE16D9AB7');
        $this->addSql('ALTER TABLE entidadesexternasiniciativas DROP FOREIGN KEY FK_C681A29C6CA204EF');
        $this->addSql('DROP INDEX IDX_C681A29CE16D9AB7 ON entidadesexternasiniciativas');
        $this->addSql('DROP INDEX IDX_C681A29C6CA204EF ON entidadesexternasiniciativas');
        $this->addSql('ALTER TABLE entidadesexternasiniciativas ADD iniciativa VARCHAR(255) DEFAULT NULL, ADD entidad VARCHAR(255) DEFAULT NULL, DROP iniciativa_id, DROP entidad_id');
        $this->addSql('ALTER TABLE iniciativas ADD eliminado TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE iniciativasmodulos DROP FOREIGN KEY FK_DBF4FF47C07F55F5');
        $this->addSql('ALTER TABLE iniciativasmodulos DROP FOREIGN KEY FK_DBF4FF47E16D9AB7');
        $this->addSql('DROP INDEX IDX_DBF4FF47C07F55F5 ON iniciativasmodulos');
        $this->addSql('DROP INDEX IDX_DBF4FF47E16D9AB7 ON iniciativasmodulos');
        $this->addSql('ALTER TABLE iniciativasmodulos ADD iniciativa VARCHAR(255) DEFAULT NULL, ADD modulo VARCHAR(255) DEFAULT NULL, DROP iniciativa_id, DROP modulo_id');
        $this->addSql('ALTER TABLE metasiniciativas CHANGE cod_iniciativa_id cod_iniciativa_id INT DEFAULT NULL, CHANGE id_metas_id id_metas_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profesoresiniciativas DROP FOREIGN KEY FK_B944D47FEC3656E');
        $this->addSql('ALTER TABLE profesoresiniciativas DROP FOREIGN KEY FK_B944D47FE16D9AB7');
        $this->addSql('DROP INDEX IDX_B944D47FE16D9AB7 ON profesoresiniciativas');
        $this->addSql('DROP INDEX IDX_B944D47FEC3656E ON profesoresiniciativas');
        $this->addSql('ALTER TABLE profesoresiniciativas ADD iniciativa VARCHAR(255) NOT NULL, ADD profesor VARCHAR(255) NOT NULL, DROP iniciativa_id, DROP trabajador_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entidadesexternasiniciativas ADD iniciativa_id INT DEFAULT NULL, ADD entidad_id INT DEFAULT NULL, DROP iniciativa, DROP entidad');
        $this->addSql('ALTER TABLE entidadesexternasiniciativas ADD CONSTRAINT FK_C681A29CE16D9AB7 FOREIGN KEY (iniciativa_id) REFERENCES iniciativas (id)');
        $this->addSql('ALTER TABLE entidadesexternasiniciativas ADD CONSTRAINT FK_C681A29C6CA204EF FOREIGN KEY (entidad_id) REFERENCES entidadesexternas (id)');
        $this->addSql('CREATE INDEX IDX_C681A29CE16D9AB7 ON entidadesexternasiniciativas (iniciativa_id)');
        $this->addSql('CREATE INDEX IDX_C681A29C6CA204EF ON entidadesexternasiniciativas (entidad_id)');
        $this->addSql('ALTER TABLE iniciativas DROP eliminado');
        $this->addSql('ALTER TABLE iniciativasmodulos ADD iniciativa_id INT DEFAULT NULL, ADD modulo_id INT DEFAULT NULL, DROP iniciativa, DROP modulo');
        $this->addSql('ALTER TABLE iniciativasmodulos ADD CONSTRAINT FK_DBF4FF47C07F55F5 FOREIGN KEY (modulo_id) REFERENCES modulos (id)');
        $this->addSql('ALTER TABLE iniciativasmodulos ADD CONSTRAINT FK_DBF4FF47E16D9AB7 FOREIGN KEY (iniciativa_id) REFERENCES iniciativas (id)');
        $this->addSql('CREATE INDEX IDX_DBF4FF47C07F55F5 ON iniciativasmodulos (modulo_id)');
        $this->addSql('CREATE INDEX IDX_DBF4FF47E16D9AB7 ON iniciativasmodulos (iniciativa_id)');
        $this->addSql('ALTER TABLE metasiniciativas CHANGE cod_iniciativa_id cod_iniciativa_id INT NOT NULL, CHANGE id_metas_id id_metas_id INT NOT NULL');
        $this->addSql('ALTER TABLE profesoresiniciativas ADD iniciativa_id INT NOT NULL, ADD trabajador_id INT NOT NULL, DROP iniciativa, DROP profesor');
        $this->addSql('ALTER TABLE profesoresiniciativas ADD CONSTRAINT FK_B944D47FEC3656E FOREIGN KEY (trabajador_id) REFERENCES profesores (id)');
        $this->addSql('ALTER TABLE profesoresiniciativas ADD CONSTRAINT FK_B944D47FE16D9AB7 FOREIGN KEY (iniciativa_id) REFERENCES iniciativas (id)');
        $this->addSql('CREATE INDEX IDX_B944D47FE16D9AB7 ON profesoresiniciativas (iniciativa_id)');
        $this->addSql('CREATE INDEX IDX_B944D47FEC3656E ON profesoresiniciativas (trabajador_id)');
    }
}
