<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200619015717 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf(
            'mysql' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql("UPDATE skill SET image_url = 'https://www.phpmexico.mx/images/logo-php.png' WHERE image_url IS NULL OR image_url = ''");
    }

    public function down(Schema $schema) : void
    {
        $this->throwIrreversibleMigrationException('The skill.image_url cannot be set to null because we could lose information.');
    }
}
