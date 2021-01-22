<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210109195039 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, semestre_id INT NOT NULL, nom VARCHAR(255) NOT NULL, sigle VARCHAR(10) NOT NULL, INDEX IDX_C2426285577AFDB (semestre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_post (module_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_E0B62981AFC2B591 (module_id), INDEX IDX_E0B629814B89032C (post_id), PRIMARY KEY(module_id, post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mot_cle (id INT AUTO_INCREMENT NOT NULL, mot_cle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, utilisateur_id INT NOT NULL, note INT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_CFBDFA144B89032C (post_id), INDEX IDX_CFBDFA14FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, createur_id INT NOT NULL, titre VARCHAR(30) NOT NULL, date_publi DATE NOT NULL, description VARCHAR(255) DEFAULT NULL, signale TINYINT(1) NOT NULL, emplacement_photo VARCHAR(255) DEFAULT NULL, INDEX IDX_5A8A6C8D73A201E5 (createur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_mot_cle (post_id INT NOT NULL, mot_cle_id INT NOT NULL, INDEX IDX_927A65194B89032C (post_id), INDEX IDX_927A6519FE94535C (mot_cle_id), PRIMARY KEY(post_id, mot_cle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ressource (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, nom VARCHAR(50) NOT NULL, type_de_fichier VARCHAR(30) NOT NULL, emplacement VARCHAR(255) NOT NULL, INDEX IDX_939F45444B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE semestre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, sigle VARCHAR(2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, mail VARCHAR(50) NOT NULL, pseudo VARCHAR(30) DEFAULT NULL, admin TINYINT(1) NOT NULL, derniere_connexion DATE DEFAULT NULL, valide TINYINT(1) NOT NULL, description VARCHAR(255) DEFAULT NULL, mot_de_passe VARCHAR(30) DEFAULT NULL, emplacement_photo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_semestre (utilisateur_id INT NOT NULL, semestre_id INT NOT NULL, INDEX IDX_6F137623FB88E14F (utilisateur_id), INDEX IDX_6F1376235577AFDB (semestre_id), PRIMARY KEY(utilisateur_id, semestre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_module (utilisateur_id INT NOT NULL, module_id INT NOT NULL, INDEX IDX_6D891CA3FB88E14F (utilisateur_id), INDEX IDX_6D891CA3AFC2B591 (module_id), PRIMARY KEY(utilisateur_id, module_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_post (utilisateur_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_930B00B7FB88E14F (utilisateur_id), INDEX IDX_930B00B74B89032C (post_id), PRIMARY KEY(utilisateur_id, post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_utilisateur (utilisateur_source INT NOT NULL, utilisateur_target INT NOT NULL, INDEX IDX_E9FA6E203E2745F8 (utilisateur_source), INDEX IDX_E9FA6E2027C21577 (utilisateur_target), PRIMARY KEY(utilisateur_source, utilisateur_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C2426285577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE module_post ADD CONSTRAINT FK_E0B62981AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module_post ADD CONSTRAINT FK_E0B629814B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA144B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D73A201E5 FOREIGN KEY (createur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE post_mot_cle ADD CONSTRAINT FK_927A65194B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_mot_cle ADD CONSTRAINT FK_927A6519FE94535C FOREIGN KEY (mot_cle_id) REFERENCES mot_cle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F45444B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE utilisateur_semestre ADD CONSTRAINT FK_6F137623FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_semestre ADD CONSTRAINT FK_6F1376235577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_module ADD CONSTRAINT FK_6D891CA3FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_module ADD CONSTRAINT FK_6D891CA3AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_post ADD CONSTRAINT FK_930B00B7FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_post ADD CONSTRAINT FK_930B00B74B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_utilisateur ADD CONSTRAINT FK_E9FA6E203E2745F8 FOREIGN KEY (utilisateur_source) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_utilisateur ADD CONSTRAINT FK_E9FA6E2027C21577 FOREIGN KEY (utilisateur_target) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE module_post DROP FOREIGN KEY FK_E0B62981AFC2B591');
        $this->addSql('ALTER TABLE utilisateur_module DROP FOREIGN KEY FK_6D891CA3AFC2B591');
        $this->addSql('ALTER TABLE post_mot_cle DROP FOREIGN KEY FK_927A6519FE94535C');
        $this->addSql('ALTER TABLE module_post DROP FOREIGN KEY FK_E0B629814B89032C');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA144B89032C');
        $this->addSql('ALTER TABLE post_mot_cle DROP FOREIGN KEY FK_927A65194B89032C');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F45444B89032C');
        $this->addSql('ALTER TABLE utilisateur_post DROP FOREIGN KEY FK_930B00B74B89032C');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C2426285577AFDB');
        $this->addSql('ALTER TABLE utilisateur_semestre DROP FOREIGN KEY FK_6F1376235577AFDB');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14FB88E14F');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D73A201E5');
        $this->addSql('ALTER TABLE utilisateur_semestre DROP FOREIGN KEY FK_6F137623FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_module DROP FOREIGN KEY FK_6D891CA3FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_post DROP FOREIGN KEY FK_930B00B7FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_utilisateur DROP FOREIGN KEY FK_E9FA6E203E2745F8');
        $this->addSql('ALTER TABLE utilisateur_utilisateur DROP FOREIGN KEY FK_E9FA6E2027C21577');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE module_post');
        $this->addSql('DROP TABLE mot_cle');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_mot_cle');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('DROP TABLE semestre');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_semestre');
        $this->addSql('DROP TABLE utilisateur_module');
        $this->addSql('DROP TABLE utilisateur_post');
        $this->addSql('DROP TABLE utilisateur_utilisateur');
    }
}
