<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200305105447 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE continent (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE decouvert ADD continent_id INT DEFAULT NULL, DROP continent');
        $this->addSql('ALTER TABLE decouvert ADD CONSTRAINT FK_476AB64B921F4C77 FOREIGN KEY (continent_id) REFERENCES continent (id)');
        $this->addSql('CREATE INDEX IDX_476AB64B921F4C77 ON decouvert (continent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE decouvert DROP FOREIGN KEY FK_476AB64B921F4C77');
        $this->addSql('DROP TABLE continent');
        $this->addSql('DROP INDEX IDX_476AB64B921F4C77 ON decouvert');
        $this->addSql('ALTER TABLE decouvert ADD continent VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP continent_id');
    }
}
