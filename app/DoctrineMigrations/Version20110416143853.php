<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20110416143853 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE portfolio_categories ADD slug VARCHAR(128) NOT NULL");
        $this->addSql("UPDATE portfolio_categories SET slug = CONCAT('category', id)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_8D5821A989D9B62 ON portfolio_categories (slug)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE portfolio_categories DROP slug");
        $this->addSql("DROP INDEX UNIQ_8D5821A989D9B62 ON portfolio_categories");
    }
}
