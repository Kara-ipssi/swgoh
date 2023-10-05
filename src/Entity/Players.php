<?php

namespace App\Entity;

use App\Repository\PlayersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Metadata\ApiProperty;


#[ORM\Entity(repositoryClass: PlayersRepository::class)]
#[UniqueEntity('allyCode')]
class Players
{
    #[ORM\Id]
    #[ApiProperty(identifier: false)]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $pseudo = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ApiProperty(identifier: true)]
    #[ORM\Column(length: 10, unique: true)]
    private ?string $allyCode = null;

    #[ORM\Column]
    private ?int $totalGalacticPower = null;

    #[ORM\Column(nullable: true)]
    private ?int $heroesGalacticPower = null;

    #[ORM\Column(nullable: true)]
    private ?int $shipsGalacticPower = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?array $heroes = null;

    #[ORM\Column(nullable: true)]
    private ?array $ships = null;

    #[ORM\Column(length: 100)]
    private ?string $guildName = null;

    #[ORM\Column(nullable: true)]
    private ?int $playerGuildMemberNb = null;

    #[ORM\Column(nullable: true)]
    private ?array $otherPlayersInGuild = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $title = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getAllyCode(): ?string
    {
        return $this->allyCode;
    }

    public function setAllyCode(string $allyCode): static
    {
        $this->allyCode = $allyCode;

        return $this;
    }

    public function getTotalGalacticPower(): ?int
    {
        return $this->totalGalacticPower;
    }

    public function setTotalGalacticPower(int $totalGalacticPower): static
    {
        $this->totalGalacticPower = $totalGalacticPower;

        return $this;
    }

    public function getHeroesGalacticPower(): ?int
    {
        return $this->heroesGalacticPower;
    }

    public function setHeroesGalacticPower(int $heroesGalacticPower): static
    {
        $this->heroesGalacticPower = $heroesGalacticPower;

        return $this;
    }

    public function getShipsGalacticPower(): ?int
    {
        return $this->shipsGalacticPower;
    }

    public function setShipsGalacticPower(int $shipsGalacticPower): static
    {
        $this->shipsGalacticPower = $shipsGalacticPower;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getHeroes(): ?array
    {
        return $this->heroes;
    }

    public function setHeroes(?array $heroes): static
    {
        $this->heroes = $heroes;

        return $this;
    }

    public function getShips(): ?array
    {
        return $this->ships;
    }

    public function setShips(?array $ships): static
    {
        $this->ships = $ships;

        return $this;
    }

    public function getGuildName(): ?string
    {
        return $this->guildName;
    }

    public function setGuildName(string $guildName): static
    {
        $this->guildName = $guildName;

        return $this;
    }

    public function getPlayerGuildMemberNb(): ?int
    {
        return $this->playerGuildMemberNb;
    }

    public function setPlayerGuildMemberNb(?int $playerGuildMemberNb): static
    {
        $this->playerGuildMemberNb = $playerGuildMemberNb;

        return $this;
    }

    public function getOtherPlayersInGuild(): ?array
    {
        return $this->otherPlayersInGuild;
    }

    public function setOtherPlayersInGuild(?array $otherPlayersInGuild): static
    {
        $this->otherPlayersInGuild = $otherPlayersInGuild;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }
}
