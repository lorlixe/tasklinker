<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210201210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, contrat VARCHAR(255) NOT NULL, date_arrivee DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, date_demarrage DATE NOT NULL, deadline DATE NOT NULL, archive TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet_employe (projet_id INT NOT NULL, employe_id INT NOT NULL, INDEX IDX_7A2E8EC8C18272 (projet_id), INDEX IDX_7A2E8EC81B65292 (employe_id), PRIMARY KEY(projet_id, employe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, projet_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, deadline DATE DEFAULT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_93872075C18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache_employe (tache_id INT NOT NULL, employe_id INT NOT NULL, INDEX IDX_3252ED0CD2235D39 (tache_id), INDEX IDX_3252ED0C1B65292 (employe_id), PRIMARY KEY(tache_id, employe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projet_employe ADD CONSTRAINT FK_7A2E8EC8C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_employe ADD CONSTRAINT FK_7A2E8EC81B65292 FOREIGN KEY (employe_id) REFERENCES employe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE tache_employe ADD CONSTRAINT FK_3252ED0CD2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tache_employe ADD CONSTRAINT FK_3252ED0C1B65292 FOREIGN KEY (employe_id) REFERENCES employe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet_employe DROP FOREIGN KEY FK_7A2E8EC8C18272');
        $this->addSql('ALTER TABLE projet_employe DROP FOREIGN KEY FK_7A2E8EC81B65292');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY FK_93872075C18272');
        $this->addSql('ALTER TABLE tache_employe DROP FOREIGN KEY FK_3252ED0CD2235D39');
        $this->addSql('ALTER TABLE tache_employe DROP FOREIGN KEY FK_3252ED0C1B65292');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE projet_employe');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE tache_employe');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
