<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130122181432 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Topic ADD user_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE Topic ADD CONSTRAINT FK_5C81F11FA76ED395 FOREIGN KEY (user_id) REFERENCES User(id)");
        $this->addSql("CREATE INDEX IDX_5C81F11FA76ED395 ON Topic (user_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Topic DROP FOREIGN KEY FK_5C81F11FA76ED395");
        $this->addSql("DROP INDEX IDX_5C81F11FA76ED395 ON Topic");
        $this->addSql("ALTER TABLE Topic DROP user_id");
    }
}
