<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200902060831 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE releve (id INT AUTO_INCREMENT NOT NULL, compteur_id INT DEFAULT NULL, user_id INT DEFAULT NULL, facture_id INT DEFAULT NULL, date DATE NOT NULL, valeur_en_chiffre NUMERIC(10, 2) NOT NULL, valeur_en_lettre VARCHAR(255) NOT NULL, INDEX IDX_DDABFF83AA3B9810 (compteur_id), INDEX IDX_DDABFF83A76ED395 (user_id), INDEX IDX_DDABFF837F2DEE08 (facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE releve ADD CONSTRAINT FK_DDABFF83AA3B9810 FOREIGN KEY (compteur_id) REFERENCES compteur (id)');
        $this->addSql('ALTER TABLE releve ADD CONSTRAINT FK_DDABFF83A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE releve ADD CONSTRAINT FK_DDABFF837F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE releve');
    }
}
