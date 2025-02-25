<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250225114814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entidadesexternas (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entidadesexternasiniciativas (id INT AUTO_INCREMENT NOT NULL, iniciativa_id INT DEFAULT NULL, entidad_id INT DEFAULT NULL, INDEX IDX_C681A29CE16D9AB7 (iniciativa_id), INDEX IDX_C681A29C6CA204EF (entidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entidadesexternasiniciativas ADD CONSTRAINT FK_C681A29CE16D9AB7 FOREIGN KEY (iniciativa_id) REFERENCES iniciativas (id)');
        $this->addSql('ALTER TABLE entidadesexternasiniciativas ADD CONSTRAINT FK_C681A29C6CA204EF FOREIGN KEY (entidad_id) REFERENCES entidadesexternas (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entidadesexternasiniciativas DROP FOREIGN KEY FK_C681A29CE16D9AB7');
        $this->addSql('ALTER TABLE entidadesexternasiniciativas DROP FOREIGN KEY FK_C681A29C6CA204EF');
        $this->addSql('DROP TABLE entidadesexternas');
        $this->addSql('DROP TABLE entidadesexternasiniciativas');
    }
}
