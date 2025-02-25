<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250225112546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profesoresmodulos (id INT AUTO_INCREMENT NOT NULL, profesor_id INT DEFAULT NULL, modulos_id INT DEFAULT NULL, INDEX IDX_9BB3C0FCE52BD977 (profesor_id), INDEX IDX_9BB3C0FC2A66C4E3 (modulos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profesoresmodulos ADD CONSTRAINT FK_9BB3C0FCE52BD977 FOREIGN KEY (profesor_id) REFERENCES profesores (id)');
        $this->addSql('ALTER TABLE profesoresmodulos ADD CONSTRAINT FK_9BB3C0FC2A66C4E3 FOREIGN KEY (modulos_id) REFERENCES modulos (id)');
        $this->addSql('ALTER TABLE trabajadoresmodulos DROP FOREIGN KEY FK_DC21202CEC3656E');
        $this->addSql('ALTER TABLE trabajadoresmodulos DROP FOREIGN KEY FK_DC21202C2A66C4E3');
        $this->addSql('DROP TABLE trabajadoresmodulos');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trabajadoresmodulos (id INT AUTO_INCREMENT NOT NULL, trabajador_id INT DEFAULT NULL, modulos_id INT DEFAULT NULL, INDEX IDX_DC21202C2A66C4E3 (modulos_id), INDEX IDX_DC21202CEC3656E (trabajador_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE trabajadoresmodulos ADD CONSTRAINT FK_DC21202CEC3656E FOREIGN KEY (trabajador_id) REFERENCES profesores (id)');
        $this->addSql('ALTER TABLE trabajadoresmodulos ADD CONSTRAINT FK_DC21202C2A66C4E3 FOREIGN KEY (modulos_id) REFERENCES modulos (id)');
        $this->addSql('ALTER TABLE profesoresmodulos DROP FOREIGN KEY FK_9BB3C0FCE52BD977');
        $this->addSql('ALTER TABLE profesoresmodulos DROP FOREIGN KEY FK_9BB3C0FC2A66C4E3');
        $this->addSql('DROP TABLE profesoresmodulos');
    }
}
