<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329154634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE filtre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filtre_chaussure (filtre_id INT NOT NULL, chaussure_id INT NOT NULL, INDEX IDX_6A726141CC9B96EA (filtre_id), INDEX IDX_6A726141F8458E35 (chaussure_id), PRIMARY KEY(filtre_id, chaussure_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE filtre_chaussure ADD CONSTRAINT FK_6A726141CC9B96EA FOREIGN KEY (filtre_id) REFERENCES filtre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE filtre_chaussure ADD CONSTRAINT FK_6A726141F8458E35 FOREIGN KEY (chaussure_id) REFERENCES chaussure (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE filtre_chaussure DROP FOREIGN KEY FK_6A726141CC9B96EA');
        $this->addSql('ALTER TABLE filtre_chaussure DROP FOREIGN KEY FK_6A726141F8458E35');
        $this->addSql('DROP TABLE filtre');
        $this->addSql('DROP TABLE filtre_chaussure');
    }
}
