<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190515225330 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_23A0E66989D9B62');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, title, slug, content, author, heart_count, image_filename, created_at, updated_at, published_at FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, slug VARCHAR(100) NOT NULL COLLATE BINARY, content CLOB DEFAULT NULL COLLATE BINARY, author VARCHAR(255) DEFAULT NULL COLLATE BINARY, heart_count INTEGER DEFAULT NULL, image_filename VARCHAR(255) DEFAULT NULL COLLATE BINARY, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, published_art DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO article (id, title, slug, content, author, heart_count, image_filename, created_at, updated_at, published_art) SELECT id, title, slug, content, author, heart_count, image_filename, created_at, updated_at, published_at FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66989D9B62 ON article (slug)');
        $this->addSql('DROP INDEX IDX_9474526C7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, article_id, author_name, content, created_at, updated_at, is_deleted FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER NOT NULL, author_name VARCHAR(255) NOT NULL COLLATE BINARY, content CLOB NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_deleted BOOLEAN NOT NULL, CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, article_id, author_name, content, created_at, updated_at, is_deleted) SELECT id, article_id, author_name, content, created_at, updated_at, is_deleted FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C7294869C ON comment (article_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_23A0E66989D9B62');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, title, slug, content, published_art, author, heart_count, image_filename, created_at, updated_at FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(100) NOT NULL, content CLOB DEFAULT NULL, author VARCHAR(255) DEFAULT NULL, heart_count INTEGER DEFAULT NULL, image_filename VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, published_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO article (id, title, slug, content, published_at, author, heart_count, image_filename, created_at, updated_at) SELECT id, title, slug, content, published_art, author, heart_count, image_filename, created_at, updated_at FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66989D9B62 ON article (slug)');
        $this->addSql('DROP INDEX IDX_9474526C7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, article_id, author_name, content, is_deleted, created_at, updated_at FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER NOT NULL, author_name VARCHAR(255) NOT NULL, content CLOB NOT NULL, is_deleted BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO comment (id, article_id, author_name, content, is_deleted, created_at, updated_at) SELECT id, article_id, author_name, content, is_deleted, created_at, updated_at FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C7294869C ON comment (article_id)');
    }
}
