<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329210653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD id_emetteur_id INT NOT NULL, ADD id_recepteur_id INT DEFAULT NULL, ADD date_lecture_message DATETIME NOT NULL, ADD contenu_message LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F61FBE37B FOREIGN KEY (id_emetteur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F18880D5F FOREIGN KEY (id_recepteur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F61FBE37B ON message (id_emetteur_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F18880D5F ON message (id_recepteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F61FBE37B');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F18880D5F');
        $this->addSql('DROP INDEX IDX_B6BD307F61FBE37B ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F18880D5F ON message');
        $this->addSql('ALTER TABLE message DROP id_emetteur_id, DROP id_recepteur_id, DROP date_lecture_message, DROP contenu_message');
    }
}
