<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191022012028 extends AbstractMigration
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
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, title, slug, content, heart_count, image_filename, created_at, updated_at, published_art FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, slug VARCHAR(100) NOT NULL COLLATE BINARY, content CLOB DEFAULT NULL COLLATE BINARY, heart_count INTEGER DEFAULT NULL, image_filename VARCHAR(255) DEFAULT NULL COLLATE BINARY, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, published_art DATETIME DEFAULT NULL, CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, title, slug, content, heart_count, image_filename, created_at, updated_at, published_art) SELECT id, title, slug, content, heart_count, image_filename, created_at, updated_at, published_art FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66989D9B62 ON article (slug)');
        $this->addSql('CREATE INDEX IDX_23A0E66F675F31B ON article (author_id)');
        $this->addSql('DROP INDEX IDX_919694F97294869C');
        $this->addSql('DROP INDEX IDX_919694F9BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article_tag AS SELECT article_id, tag_id FROM article_tag');
        $this->addSql('DROP TABLE article_tag');
        $this->addSql('CREATE TABLE article_tag (article_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(article_id, tag_id), CONSTRAINT FK_919694F97294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_919694F9BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article_tag (article_id, tag_id) SELECT article_id, tag_id FROM __temp__article_tag');
        $this->addSql('DROP TABLE __temp__article_tag');
        $this->addSql('CREATE INDEX IDX_919694F97294869C ON article_tag (article_id)');
        $this->addSql('CREATE INDEX IDX_919694F9BAD26311 ON article_tag (tag_id)');
        $this->addSql('DROP INDEX IDX_7BA2F5EBA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__api_token AS SELECT id, user_id, token, expire_at FROM api_token');
        $this->addSql('DROP TABLE api_token');
        $this->addSql('CREATE TABLE api_token (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, token VARCHAR(255) NOT NULL COLLATE BINARY, expire_at DATETIME DEFAULT NULL, CONSTRAINT FK_7BA2F5EBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO api_token (id, user_id, token, expire_at) SELECT id, user_id, token, expire_at FROM __temp__api_token');
        $this->addSql('DROP TABLE __temp__api_token');
        $this->addSql('CREATE INDEX IDX_7BA2F5EBA76ED395 ON api_token (user_id)');
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

        $this->addSql('DROP INDEX IDX_7BA2F5EBA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__api_token AS SELECT id, user_id, token, expire_at FROM api_token');
        $this->addSql('DROP TABLE api_token');
        $this->addSql('CREATE TABLE api_token (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, token VARCHAR(255) NOT NULL, expire_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO api_token (id, user_id, token, expire_at) SELECT id, user_id, token, expire_at FROM __temp__api_token');
        $this->addSql('DROP TABLE __temp__api_token');
        $this->addSql('CREATE INDEX IDX_7BA2F5EBA76ED395 ON api_token (user_id)');
        $this->addSql('DROP INDEX UNIQ_23A0E66989D9B62');
        $this->addSql('DROP INDEX IDX_23A0E66F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, title, slug, content, published_art, heart_count, image_filename, created_at, updated_at FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(100) NOT NULL, content CLOB DEFAULT NULL, published_art DATETIME DEFAULT NULL, heart_count INTEGER DEFAULT NULL, image_filename VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, author VARCHAR(255) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO article (id, title, slug, content, published_art, heart_count, image_filename, created_at, updated_at) SELECT id, title, slug, content, published_art, heart_count, image_filename, created_at, updated_at FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66989D9B62 ON article (slug)');
        $this->addSql('DROP INDEX IDX_919694F97294869C');
        $this->addSql('DROP INDEX IDX_919694F9BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article_tag AS SELECT article_id, tag_id FROM article_tag');
        $this->addSql('DROP TABLE article_tag');
        $this->addSql('CREATE TABLE article_tag (article_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(article_id, tag_id))');
        $this->addSql('INSERT INTO article_tag (article_id, tag_id) SELECT article_id, tag_id FROM __temp__article_tag');
        $this->addSql('DROP TABLE __temp__article_tag');
        $this->addSql('CREATE INDEX IDX_919694F97294869C ON article_tag (article_id)');
        $this->addSql('CREATE INDEX IDX_919694F9BAD26311 ON article_tag (tag_id)');
        $this->addSql('DROP INDEX IDX_9474526C7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, article_id, author_name, content, is_deleted, created_at, updated_at FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER NOT NULL, author_name VARCHAR(255) NOT NULL, content CLOB NOT NULL, is_deleted BOOLEAN NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO comment (id, article_id, author_name, content, is_deleted, created_at, updated_at) SELECT id, article_id, author_name, content, is_deleted, created_at, updated_at FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C7294869C ON comment (article_id)');
    }
}
