<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231003132501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE players (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(50) NOT NULL, level INT NOT NULL, ally_code VARCHAR(10) NOT NULL, total_galactic_power INT NOT NULL, heroes_galactic_power INT DEFAULT NULL, ships_galactic_power INT DEFAULT NULL, url VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', heroes JSON DEFAULT NULL, ships JSON DEFAULT NULL, guild_name VARCHAR(100) NOT NULL, player_guild_member_nb INT DEFAULT NULL, other_players_in_guild JSON DEFAULT NULL, title VARCHAR(100) DEFAULT NULL, UNIQUE INDEX UNIQ_264E43A6A67CF9BB (ally_code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE players');
    }
}
