<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201127131115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update meetup_event to slugify the title and add a unique index';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
UPDATE meetup_event
SET slug = lower(title),
    slug = replace(slug, '.', ' '),
    slug = replace(slug, ',', ' '),
    slug = replace(slug, ';', ' '),
    slug = replace(slug, ':', ' '),
    slug = replace(slug, '?', ' '),
    slug = replace(slug, '%', ' '),
    slug = replace(slug, '&', ' '),
    slug = replace(slug, '#', ' '),
    slug = replace(slug, '*', ' '),
    slug = replace(slug, '!', ' '),
    slug = replace(slug, '_', ' '),
    slug = replace(slug, '@', ' '),
    slug = replace(slug, '+', ' '),
    slug = replace(slug, '(', ' '),
    slug = replace(slug, ')', ' '),
    slug = replace(slug, '[', ' '),
    slug = replace(slug, ']', ' '),
    slug = replace(slug, '/', ' '),
    slug = replace(slug, '-', ' '),
    slug = replace(slug, '\'', ''),
    slug = replace(slug, 'á', 'a'),
    slug = replace(slug, 'é', 'e'),
    slug = replace(slug, 'í', 'i'),
    slug = replace(slug, 'ó', 'o'),
    slug = replace(slug, 'ú', 'u'),
    slug = trim(slug),
    slug = replace(slug, ' ', '-'),
    slug = replace(slug, '--', '-')
SQL;

        $this->addSql($sql);
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7EA6C459989D9B62 ON meetup_event (slug)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_7EA6C459989D9B62 ON meetup_event');
        $this->addSql('UPDATE meetup_event SET slug = ""');
    }
}
