<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130105180738 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Meeting ADD topic1 VARCHAR(255) DEFAULT NULL, ADD topic2 VARCHAR(255) DEFAULT NULL, ADD topic3 VARCHAR(255) DEFAULT NULL, ADD topic4 VARCHAR(255) DEFAULT NULL, ADD topic5 VARCHAR(255) DEFAULT NULL, ADD topic6 VARCHAR(255) DEFAULT NULL, ADD topic7 VARCHAR(255) DEFAULT NULL, ADD topic8 VARCHAR(255) DEFAULT NULL, ADD topic9 VARCHAR(255) DEFAULT NULL, ADD topic10 VARCHAR(255) DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Meeting DROP topic1, DROP topic2, DROP topic3, DROP topic4, DROP topic5, DROP topic6, DROP topic7, DROP topic8, DROP topic9, DROP topic10");
    }
}
