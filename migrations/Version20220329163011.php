<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329163011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, nom_image VARCHAR(20) NOT NULL, taille_image DOUBLE PRECISION NOT NULL, type_image VARCHAR(5) NOT NULL, bin_image BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet (id INT AUTO_INCREMENT NOT NULL, id_utilisateur_id INT NOT NULL, lieu_depart_trajet VARCHAR(20) NOT NULL, lieu_arrivee_trajet VARCHAR(20) NOT NULL, detour_max_trajet DOUBLE PRECISION NOT NULL, date_depart DATE NOT NULL, format_objet VARCHAR(3) NOT NULL, INDEX IDX_2B5BA98CC6EE5C49 (id_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, id_iamge_id INT NOT NULL, nom_utilisateur VARCHAR(20) NOT NULL, prenom_utilisateur VARCHAR(20) NOT NULL, date_naissance_utilisateur DATE NOT NULL, addresse_utilisateur VARCHAR(50) NOT NULL, email_utilisateur VARCHAR(20) NOT NULL, password_utilisateur VARCHAR(10) NOT NULL, telephone_utilisateur VARCHAR(15) NOT NULL, num_carte_butilisateur VARCHAR(20) NOT NULL, genre_utilisateur VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3DD1C63F7 (id_iamge_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DD1C63F7 FOREIGN KEY (id_iamge_id) REFERENCES image (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3DD1C63F7');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CC6EE5C49');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE utilisateur');
    }
}
