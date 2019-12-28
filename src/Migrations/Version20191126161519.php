<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191126161519 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE episode ADD program_id INT NOT NULL, ADD saison_id INT NOT NULL');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA3EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDAF965414C FOREIGN KEY (saison_id) REFERENCES saison (id)');
        $this->addSql('CREATE INDEX IDX_DDAA1CDA3EB8070A ON episode (program_id)');
        $this->addSql('CREATE INDEX IDX_DDAA1CDAF965414C ON episode (saison_id)');
        $this->addSql('ALTER TABLE saison ADD program_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE saison ADD CONSTRAINT FK_C0D0D5863EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('CREATE INDEX IDX_C0D0D5863EB8070A ON saison (program_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA3EB8070A');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDAF965414C');
        $this->addSql('DROP INDEX IDX_DDAA1CDA3EB8070A ON episode');
        $this->addSql('DROP INDEX IDX_DDAA1CDAF965414C ON episode');
        $this->addSql('ALTER TABLE episode DROP program_id, DROP saison_id');
        $this->addSql('ALTER TABLE saison DROP FOREIGN KEY FK_C0D0D5863EB8070A');
        $this->addSql('DROP INDEX IDX_C0D0D5863EB8070A ON saison');
        $this->addSql('ALTER TABLE saison DROP program_id');
    }
}
