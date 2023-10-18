<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiProperty;
use App\Repository\PlayersRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

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
    #[Groups(['playerData'])]
    private ?string $pseudo = null;

    #[ORM\Column]
    #[Groups(['playerData'])]
    private ?int $level = null;

    #[ApiProperty(identifier: true)]
    #[ORM\Column(length: 10, unique: true)]
    #[Groups(['playerData'])]
    private ?string $allyCode = null;

    #[ORM\Column]
    #[Groups(['playerData'])]
    private ?int $totalGalacticPower = null;

    #[ORM\Column(length: 255)]
    #[Groups(['playerData'])]
    private ?string $url = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['playerData'])]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    #[Groups(['playerData'])]
    private ?Guilds $guild = null;

    #[ORM\ManyToMany(targetEntity: Units::class, inversedBy: 'players')]
    // #[Groups(['playerData'])]
    private Collection $units;

    #[ORM\Column]
    #[Groups(['playerData'])]
    private ?int $characterGalacticPower = null;

    #[ORM\Column]
    #[Groups(['playerData'])]
    private ?int $shipGalacticPower = null;

    public function __construct()
    {
        $this->units = new ArrayCollection();
    }

    // #[ORM\OneToMany(mappedBy: 'player', targetEntity: PlayerUnits::class)]
    // private Collection $playerUnits;

    // public function __construct()
    // {
    //     $this->playerUnits = new ArrayCollection();
    // }

    
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

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

    public function getGuild(): ?Guilds
    {
        return $this->guild;
    }

    public function setGuild(?Guilds $guild): static
    {
        $this->guild = $guild;

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
    //         $playerUnit->setPlayer($this);
    //     }

    //     return $this;
    // }

    // public function removePlayerUnit(PlayerUnits $playerUnit): static
    // {
    //     if ($this->playerUnits->removeElement($playerUnit)) {
    //         // set the owning side to null (unless already changed)
    //         if ($playerUnit->getPlayer() === $this) {
    //             $playerUnit->setPlayer(null);
    //         }
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, Units>
     */
    public function getUnits(): Collection
    {
        return $this->units;
    }

    public function addUnit(Units $unit): static
    {
        if (!$this->units->contains($unit)) {
            $this->units->add($unit);
        }

        return $this;
    }

    public function removeUnit(Units $unit): static
    {
        $this->units->removeElement($unit);

        return $this;
    }

    public function getCharacterGalacticPower(): ?int
    {
        return $this->characterGalacticPower;
    }

    public function setCharacterGalacticPower(int $characterGalacticPower): static
    {
        $this->characterGalacticPower = $characterGalacticPower;

        return $this;
    }

    public function getShipGalacticPower(): ?int
    {
        return $this->shipGalacticPower;
    }

    public function setShipGalacticPower(int $shipGalacticPower): static
    {
        $this->shipGalacticPower = $shipGalacticPower;

        return $this;
    }
}
