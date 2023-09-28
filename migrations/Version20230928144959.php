<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230928144959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE players ADD heroes JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', ADD ships JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', ADD guild_name VARCHAR(100) NOT NULL, ADD player_guild_member_nb INT DEFAULT NULL, ADD other_players_in_guild JSON DEFAULT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE players DROP heroes, DROP ships, DROP guild_name, DROP player_guild_member_nb, DROP other_players_in_guild');
    }
}
