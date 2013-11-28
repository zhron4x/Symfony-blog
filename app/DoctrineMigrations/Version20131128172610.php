<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131128172610 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, author VARCHAR(100) NOT NULL, blog LONGTEXT NOT NULL, image VARCHAR(20) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, posted TINYINT(1) NOT NULL, INDEX IDX_C015514312469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE blog_tags (blog_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_8F6C18B6DAE07E97 (blog_id), INDEX IDX_8F6C18B6BAD26311 (tag_id), PRIMARY KEY(blog_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, isDefault TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, blog_id INT DEFAULT NULL, user VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, approved TINYINT(1) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_9474526CDAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, weight INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE blog ADD CONSTRAINT FK_C015514312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)");
        $this->addSql("ALTER TABLE blog_tags ADD CONSTRAINT FK_8F6C18B6DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)");
        $this->addSql("ALTER TABLE blog_tags ADD CONSTRAINT FK_8F6C18B6BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)");
        $this->addSql("ALTER TABLE comment ADD CONSTRAINT FK_9474526CDAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE blog_tags DROP FOREIGN KEY FK_8F6C18B6DAE07E97");
        $this->addSql("ALTER TABLE comment DROP FOREIGN KEY FK_9474526CDAE07E97");
        $this->addSql("ALTER TABLE blog DROP FOREIGN KEY FK_C015514312469DE2");
        $this->addSql("ALTER TABLE blog_tags DROP FOREIGN KEY FK_8F6C18B6BAD26311");
        $this->addSql("DROP TABLE blog");
        $this->addSql("DROP TABLE blog_tags");
        $this->addSql("DROP TABLE category");
        $this->addSql("DROP TABLE comment");
        $this->addSql("DROP TABLE tag");
    }
}