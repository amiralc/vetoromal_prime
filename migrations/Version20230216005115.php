<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230216005115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordonnance ADD rendezvous_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ordonnance ADD CONSTRAINT FK_924B326C3345E0A3 FOREIGN KEY (rendezvous_id) REFERENCES rendez_vous (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_924B326C3345E0A3 ON ordonnance (rendezvous_id)');
        $this->addSql('ALTER TABLE rendez_vous ADD animal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0A8E962C16 ON rendez_vous (animal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ordonnance DROP FOREIGN KEY FK_924B326C3345E0A3');
        $this->addSql('DROP INDEX UNIQ_924B326C3345E0A3 ON ordonnance');
        $this->addSql('ALTER TABLE ordonnance DROP rendezvous_id');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A8E962C16');
        $this->addSql('DROP INDEX IDX_65E8AA0A8E962C16 ON rendez_vous');
        $this->addSql('ALTER TABLE rendez_vous DROP animal_id');
    }
}
