<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UnitsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UnitsRepository::class)]
#[UniqueEntity('name')]
#[UniqueEntity('baseId')]
class Units
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['unitSelectedData', 'playerData'])]
    private ?string $url = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['unitSelectedData', 'playerData'])]
    private ?string $image = null;

    #[ORM\Column]
    #[Groups(['unitSelectedData', 'playerData'])]
    private ?int $power = null;

    #[ORM\Column]
    #[Groups(['unitSelectedData', 'playerData'])]
    private ?int $combatType = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['unitSelectedData', 'playerData'])]
    private string $name = "";

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['unitSelectedData', 'playerData'])]
    private string $baseId = "";

    #[ORM\ManyToMany(targetEntity: Players::class, mappedBy: 'units')]
    private Collection $players;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

    // #[ORM\OneToMany(mappedBy: 'unit', targetEntity: PlayerUnits::class)]
    // private Collection $playerUnits;

    // public function __construct()
    // {
    //     $this->playerUnits = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(int $power): static
    {
        $this->power = $power;

        return $this;
    }

    public function getCombatType(): ?int
    {
        return $this->combatType;
    }

    public function setCombatType(int $combatType): static
    {
        $this->combatType = $combatType;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBaseId(): ?string
    {
        return $this->baseId;
    }

    public function setBaseId(string $baseId): static
    {
        $this->baseId = $baseId;

        return $this;
    }

    // /**
    //  * @return Collection<int, PlayerUnits>
    //  */
    // public function getPlayerUnits(): Collection
    // {
    //     return $this->playerUnits;
    // }

    // public function addPlayerUnit(PlayerUnits $playerUnit): static
    // {
    //     if (!$this->playerUnits->contains($playerUnit)) {
    //         $this->playerUnits->add($playerUnit);
    //         $playerUnit->setUnit($this);
    //     }

    //     return $this;
    // }

    // public function removePlayerUnit(PlayerUnits $playerUnit): static
    // {
    //     if ($this->playerUnits->removeElement($playerUnit)) {
    //         // set the owning side to null (unless already changed)
    //         if ($playerUnit->getUnit() === $this) {
    //             $playerUnit->setUnit(null);
    //         }
    //     }

    //     return $this;
    // }

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
            $player->addUnit($this);
        }

        return $this;
    }

    public function removePlayer(Players $player): static
    {
        if ($this->players->removeElement($player)) {
            $player->removeUnit($this);
        }

        return $this;
    }
}
