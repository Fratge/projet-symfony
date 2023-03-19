<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230319131035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_24CC0DF2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier_chaussure (panier_id INT NOT NULL, chaussure_id INT NOT NULL, INDEX IDX_FD452D8EF77D927C (panier_id), INDEX IDX_FD452D8EF8458E35 (chaussure_id), PRIMARY KEY(panier_id, chaussure_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier_chaussure ADD CONSTRAINT FK_FD452D8EF77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_chaussure ADD CONSTRAINT FK_FD452D8EF8458E35 FOREIGN KEY (chaussure_id) REFERENCES chaussure (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2A76ED395');
        $this->addSql('ALTER TABLE panier_chaussure DROP FOREIGN KEY FK_FD452D8EF77D927C');
        $this->addSql('ALTER TABLE panier_chaussure DROP FOREIGN KEY FK_FD452D8EF8458E35');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE panier_chaussure');
    }
}
