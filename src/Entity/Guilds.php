<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GuildsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GuildsRepository::class)]
class Guilds
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'string', length: 255, nullable: false)]
    #[Groups(['playerData'])]
    private ?string $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['playerData'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['playerData'])]
    private ?int $galacticPower = null;

    #[ORM\Column]
    #[Groups(['playerData'])]
    private ?int $memberCount = null;

    #[ORM\OneToMany(mappedBy: 'guild', targetEntity: Players::class)]
    private Collection $players;

    public function __construct()
    {
        $this->players = new ArrayCollection();

    }


    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): ?string
    {
        $this->id = $id;
            
        return $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getGalacticPower(): ?int
    {
        return $this->galacticPower;
    }

    public function setGalacticPower(int $galacticPower): static
    {
        $this->galacticPower = $galacticPower;

        return $this;
    }

    public function getMemberCount(): ?int
    {
        return $this->memberCount;
    }

    public function setMemberCount(int $memberCount): static
    {
        $this->memberCount = $memberCount;

        return $this;
    }

    /**
     * @return Collection<int, Players>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Players $player): static
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->setGuild($this);
        }

        return $this;
    }

    public function removePlayer(Players $player): static
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getGuild() === $this) {
                $player->setGuild(null);
            }
        }

        return $this;
    }
}
