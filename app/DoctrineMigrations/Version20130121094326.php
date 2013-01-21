<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130121094326 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Meeting ADD owner_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE Meeting ADD CONSTRAINT FK_3AA8D8A57E3C61F9 FOREIGN KEY (owner_id) REFERENCES User(id)");
        $this->addSql("CREATE INDEX IDX_3AA8D8A57E3C61F9 ON Meeting (owner_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Meeting DROP FOREIGN KEY FK_3AA8D8A57E3C61F9");
        $this->addSql("DROP INDEX IDX_3AA8D8A57E3C61F9 ON Meeting");
        $this->addSql("ALTER TABLE Meeting DROP owner_id");
    }
}
