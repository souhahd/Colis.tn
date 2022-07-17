<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329201207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, adresse_depart VARCHAR(100) NOT NULL, adresse_arrivee VARCHAR(100) NOT NULL, prix_proposee DOUBLE PRECISION NOT NULL, date_proposee DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, titre_article VARCHAR(20) NOT NULL, contenu_article VARCHAR(255) NOT NULL, visibilite_article TINYINT(1) NOT NULL, date_pub_article DATE NOT NULL, auteur_article VARCHAR(20) NOT NULL, source_article VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE colis (id INT AUTO_INCREMENT NOT NULL, id_annonce_id INT NOT NULL, objet_colis VARCHAR(10) NOT NULL, quantite_colis INT NOT NULL, largeur_colis DOUBLE PRECISION NOT NULL, longeur_colis DOUBLE PRECISION NOT NULL, hauteur_colis DOUBLE PRECISION NOT NULL, poids_unitaire_colis DOUBLE PRECISION NOT NULL, INDEX IDX_470BDFF92D8F2BF8 (id_annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, id_commentaire_id INT NOT NULL, contenu_commentaire LONGTEXT NOT NULL, date_commentaire DATETIME NOT NULL, visibilite_commentaire TINYINT(1) NOT NULL, INDEX IDX_67F068BC87FA6C96 (id_commentaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE colis ADD CONSTRAINT FK_470BDFF92D8F2BF8 FOREIGN KEY (id_annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC87FA6C96 FOREIGN KEY (id_commentaire_id) REFERENCES article (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE colis DROP FOREIGN KEY FK_470BDFF92D8F2BF8');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC87FA6C96');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE colis');
        $this->addSql('DROP TABLE commentaire');
    }
}
