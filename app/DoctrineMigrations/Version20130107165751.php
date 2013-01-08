<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130107165751 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE Topic (id INT AUTO_INCREMENT NOT NULL, meeting_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, position INT NOT NULL, owner VARCHAR(255) NOT NULL, INDEX IDX_5C81F11F67433D9C (meeting_id), PRIMARY KEY(id)) ENGINE = InnoDB");
        $this->addSql("ALTER TABLE Topic ADD CONSTRAINT FK_5C81F11F67433D9C FOREIGN KEY (meeting_id) REFERENCES Meeting(id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE Topic");
    }
}
