<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181127083711 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, numrue INT DEFAULT NULL, rue VARCHAR(50) DEFAULT NULL, copos VARCHAR(5) DEFAULT NULL, ville VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT DEFAULT NULL, tuteur_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, objet VARCHAR(255) NOT NULL, INDEX IDX_C27C9369A4AEAFEA (entreprise_id), INDEX IDX_C27C936986EC68D8 (tuteur_id), INDEX IDX_C27C9369DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage_competence (stage_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_D88E73DB2298D193 (stage_id), INDEX IDX_D88E73DB15761DAB (competence_id), PRIMARY KEY(stage_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tuteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, mail VARCHAR(100) DEFAULT NULL, telephone VARCHAR(14) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C936986EC68D8 FOREIGN KEY (tuteur_id) REFERENCES tuteur (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE stage_competence ADD CONSTRAINT FK_D88E73DB2298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage_competence ADD CONSTRAINT FK_D88E73DB15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369A4AEAFEA');
        $this->addSql('ALTER TABLE stage_competence DROP FOREIGN KEY FK_D88E73DB2298D193');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C936986EC68D8');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE stage_competence');
        $this->addSql('DROP TABLE tuteur');
    }
}
