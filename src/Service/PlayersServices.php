<?php

namespace App\Service;

use App\Entity\Units;
use App\Entity\Guilds;
use App\Entity\Players;
use Psr\Log\LoggerInterface;
use App\Service\UnitsServices;
use App\Service\GuildsServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class PlayersServices
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface $logger,
        private readonly GlobalServices $globalServices,
        private readonly GuildsServices $guildsServices,
        private readonly UnitsServices $UnitsServices,
    )
    {}

    public function getPlayer(string $allyCode) : Players | array | JsonResponse 
    {
        try{
            $player = $this->entityManager->getRepository(Players::class)->findOneByAllyCode($allyCode);
            if(!$player){
                $player = $this->savePlayer($allyCode);
            }
            $url = "https://swgoh.gg/api/player/".$allyCode;
            $data = $this->globalServices->getApi($url);
            $playerUnits = $data['units'];
            $playerUnitsMoreData = [];
            foreach ($player->getUnits() as $unit) {
                // Je veux récupérer les données de l'unité en question qui sont dans le tableau $playerUnits
                // Je dois donc parcourir le tableau $playerUnits et comparer les baseId
                // Si le baseId de l'unité en cours de la boucle est égal au baseId de l'unité en cours de la boucle de $playerUnits
                foreach ($playerUnits as $unitMoreData) {
                    $unitMoreData = $unitMoreData['data'];
                    // dd($unitMoreData);
                    if($unit->getBaseId() === $unitMoreData['base_id']){

                        $u["name"] = $unit->getName();
                        $u["baseId"] = $unit->getBaseId();
                        $u['image'] = $unit->getImage();
                        $u["url"] = $unit->getUrl();
                        $u["power"] = $unitMoreData['power'];
                        $u["combatType"] = $unit->getCombatType();
                        $u["level"] = $unitMoreData['level'];
                        $u["rarity"] = $unitMoreData['rarity'];
                        $u["stats"] = $unitMoreData['stats'];

                        $playerUnitsMoreData[] = $u;
                    }
                }
            }
            $heroes = [];
            $ships = [];
            foreach ($playerUnitsMoreData as $unit) {
                if($unit['combatType'] === 1){
                    $heroes[] = $unit;
                }else{
                    $ships[] = $unit;
                }
            }
            return [
                'playerData' => $player,
                'units' => [
                    'heroes' => $heroes,
                    'ships' => $ships,
                ]
            ];
        } catch (\Throwable $e) {
            return $this->globalServices->prepareErrorJsonResponse($e->getMessage());
        }
    }

    public function savePlayer(string $allyCode) : Players | JsonResponse
    {
        $url = "https://swgoh.gg/api/player/".$allyCode;
        
        try {
            $data = $this->globalServices->getApi($url);
            $playerData = $data['data'];
            $playerUnits = $data['units'];
            $player = $this->createPlayerEntity($playerData, $allyCode);
            if($playerData['guild_id']){
                $guildId = $playerData['guild_id'];

                $guild = $this->entityManager->getRepository(Guilds::class)->findOneById($guildId);
                if(!$guild){
                    $guild = $this->guildsServices->saveGuild($guildId);
                }
                
                $player->setGuild($guild);
            }

            foreach ($playerUnits as $unit) {
                $unit = $unit['data'];
                
                $dbUnit = $this->entityManager->getRepository(Units::class)->findOneByBaseId($unit['base_id']);
                // dd($unit, json_decode($this->globalServices->serializeData($dbUnit), true));
                if(!$dbUnit){
                    $dbUnit = $this->UnitsServices->saveOneUnit($unit);
                }
                $player->addUnit($dbUnit);
            }
            $this->entityManager->persist($player);
            $this->entityManager->flush();
            return $player;
        } catch (\Throwable $e) {
            return $this->globalServices->prepareErrorJsonResponse($e->getMessage());
        }
    }

    public function updatePlayer(string $allyCode) : array | JsonResponse 
    {
        try{
            $player = $this->entityManager->getRepository(Players::class)->findOneByAllyCode($allyCode);
            if($player){
                $url = "https://swgoh.gg/api/player/".$allyCode;
                $data = $this->globalServices->getApi($url);
                $playerData = $data['data'];
                $playerUnits = $data['units'];
                $player->setPseudo($playerData["name"]);
                $player->setTitle($playerData["title"]);
                $player->setLevel($playerData["level"]);
                $player->setTotalGalacticPower($playerData["galactic_power"]);
                $player->setCharacterGalacticPower($playerData["character_galactic_power"]);
                $player->setShipGalacticPower($playerData["ship_galactic_power"]);
                $player->setUrl("https://swgoh.gg".$playerData["url"]);
                $player->setGuild(null);
                if($playerData['guild_id']){
                    $guildId = $playerData['guild_id'];
                    $guild = $this->entityManager->getRepository(Guilds::class)->findOneById($guildId);
                    if(!$guild){
                        $guild = $this->guildsServices->saveGuild($guildId);
                    }
                    $player->setGuild($guild);
                }
                foreach ($playerUnits as $unit) {
                    $unit = $unit['data'];
                    $dbUnit = $this->entityManager->getRepository(Units::class)->findOneByBaseId($unit['base_id']);
                    if(!$dbUnit){
                        $dbUnit = $this->UnitsServices->saveOneUnit($unit);
                    }
                    $player->addUnit($dbUnit);
                }
                $this->entityManager->persist($player);
                $this->entityManager->flush();
            }
            return $this->getPlayer($allyCode);
        } catch (\Throwable $e) {
            return $this->globalServices->prepareErrorJsonResponse($e->getMessage());
        }
    }

    public function createPlayerEntity(array $playerData, string $allyCode): Players
    {
        $player = new Players();
        $player->setPseudo($playerData["name"]);
        $player->setTitle($playerData["title"]);
        $player->setLevel($playerData["level"]);
        $player->setAllyCode($allyCode);
        $player->setTotalGalacticPower($playerData["galactic_power"]);
        $player->setCharacterGalacticPower($playerData["character_galactic_power"]);
        $player->setShipGalacticPower($playerData["ship_galactic_power"]);
        $player->setUrl("https://swgoh.gg".$playerData["url"]);
        return $player;
    }
}