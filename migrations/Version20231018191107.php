<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231018191107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE guilds (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, galactic_power INT NOT NULL, member_count INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE players (id INT AUTO_INCREMENT NOT NULL, guild_id VARCHAR(255) DEFAULT NULL, pseudo VARCHAR(50) NOT NULL, level INT NOT NULL, ally_code VARCHAR(10) NOT NULL, total_galactic_power INT NOT NULL, url VARCHAR(255) NOT NULL, title VARCHAR(100) DEFAULT NULL, UNIQUE INDEX UNIQ_264E43A6A67CF9BB (ally_code), INDEX IDX_264E43A65F2131EF (guild_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE players_units (players_id INT NOT NULL, units_id INT NOT NULL, INDEX IDX_F4955DE3F1849495 (players_id), INDEX IDX_F4955DE399387CE8 (units_id), PRIMARY KEY(players_id, units_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE units (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, power INT NOT NULL, combat_type INT NOT NULL, name VARCHAR(255) NOT NULL, base_id VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E9B074495E237E06 (name), UNIQUE INDEX UNIQ_E9B074496967DF41 (base_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE players ADD CONSTRAINT FK_264E43A65F2131EF FOREIGN KEY (guild_id) REFERENCES guilds (id)');
        $this->addSql('ALTER TABLE players_units ADD CONSTRAINT FK_F4955DE3F1849495 FOREIGN KEY (players_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE players_units ADD CONSTRAINT FK_F4955DE399387CE8 FOREIGN KEY (units_id) REFERENCES units (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE players DROP FOREIGN KEY FK_264E43A65F2131EF');
        $this->addSql('ALTER TABLE players_units DROP FOREIGN KEY FK_F4955DE3F1849495');
        $this->addSql('ALTER TABLE players_units DROP FOREIGN KEY FK_F4955DE399387CE8');
        $this->addSql('DROP TABLE guilds');
        $this->addSql('DROP TABLE players');
        $this->addSql('DROP TABLE players_units');
        $this->addSql('DROP TABLE units');
    }
}
