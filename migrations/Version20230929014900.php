<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230929014900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE players CHANGE heroes_galactic_power heroes_galactic_power INT DEFAULT NULL, CHANGE ships_galactic_power ships_galactic_power INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_264E43A6A67CF9BB ON players (ally_code)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_264E43A6A67CF9BB ON players');
        $this->addSql('ALTER TABLE players CHANGE heroes_galactic_power heroes_galactic_power INT NOT NULL, CHANGE ships_galactic_power ships_galactic_power INT NOT NULL');
    }
}
