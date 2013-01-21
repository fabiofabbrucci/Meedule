<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130121111234 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Attendee ADD user_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE Attendee ADD CONSTRAINT FK_E826B731A76ED395 FOREIGN KEY (user_id) REFERENCES User(id)");
        $this->addSql("CREATE INDEX IDX_E826B731A76ED395 ON Attendee (user_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Attendee DROP FOREIGN KEY FK_E826B731A76ED395");
        $this->addSql("DROP INDEX IDX_E826B731A76ED395 ON Attendee");
        $this->addSql("ALTER TABLE Attendee DROP user_id");
    }
}
