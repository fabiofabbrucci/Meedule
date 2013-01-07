<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130107110440 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE UNIQUE INDEX UNIQ_3AA8D8A56474467C ON Meeting (slugpublic)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_3AA8D8A5E8EC5077 ON Meeting (slugprivate)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP INDEX UNIQ_3AA8D8A56474467C ON Meeting");
        $this->addSql("DROP INDEX UNIQ_3AA8D8A5E8EC5077 ON Meeting");
    }
}
