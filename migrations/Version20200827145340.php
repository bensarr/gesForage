<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200827145340 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_351268BBA76ED395 ON abonnement (user_id)');
        $this->addSql('ALTER TABLE compteur ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE compteur ADD CONSTRAINT FK_4D021BD5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4D021BD5A76ED395 ON compteur (user_id)');
        $this->addSql('ALTER TABLE facture ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FE866410A76ED395 ON facture (user_id)');
        $this->addSql('ALTER TABLE releve ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE releve ADD CONSTRAINT FK_DDABFF83A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DDABFF83A76ED395 ON releve (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBA76ED395');
        $this->addSql('DROP INDEX IDX_351268BBA76ED395 ON abonnement');
        $this->addSql('ALTER TABLE abonnement DROP user_id');
        $this->addSql('ALTER TABLE compteur DROP FOREIGN KEY FK_4D021BD5A76ED395');
        $this->addSql('DROP INDEX IDX_4D021BD5A76ED395 ON compteur');
        $this->addSql('ALTER TABLE compteur DROP user_id');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410A76ED395');
        $this->addSql('DROP INDEX IDX_FE866410A76ED395 ON facture');
        $this->addSql('ALTER TABLE facture DROP user_id');
        $this->addSql('ALTER TABLE releve DROP FOREIGN KEY FK_DDABFF83A76ED395');
        $this->addSql('DROP INDEX IDX_DDABFF83A76ED395 ON releve');
        $this->addSql('ALTER TABLE releve DROP user_id');
    }
}
