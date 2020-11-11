<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201111230154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE meetup_event ADD youtube_url VARCHAR(255) DEFAULT NULL, ADD twitter_url VARCHAR(255) DEFAULT NULL, ADD facebook_url VARCHAR(255) DEFAULT NULL, ADD slide_url VARCHAR(255) DEFAULT NULL, ADD speaker_linkedin_url VARCHAR(255) DEFAULT NULL, ADD speaker_git_url VARCHAR(255) DEFAULT NULL, ADD speaker_twitter_url VARCHAR(255) DEFAULT NULL, ADD speaker_facebook_url VARCHAR(255) DEFAULT NULL, ADD created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE meetup_event DROP youtube_url, DROP twitter_url, DROP facebook_url, DROP slide_url, DROP speaker_linkedin_url, DROP speaker_git_url, DROP speaker_twitter_url, DROP speaker_facebook_url, DROP created_at, DROP updated_at');
    }
}
