<?php

namespace App\Controller;

use App\Entity\Players;
use App\Repository\PlayersRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Header;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PlayersController extends AbstractController
{
    #[Route('/api/{allyCode}/guild', name: 'get_guild_by_allyCode')]
    public function getGuildByAllyCode(HttpClientInterface $client, string $allyCode, bool $internal = false): JsonResponse
    {
        $response = $client->request(
            "GET",
            "https://swgoh.gg/api/player/$allyCode/"
        );
        $playerData = $response->toArray();
        $guildId = $playerData['data']['guild_id'];

        $guildResponse = $client->request(
            "GET",
            "https://swgoh.gg/api/guild-profile/$guildId/"
        );

        $guildData = $guildResponse->toArray();

        // set data to return
        $dataToReturn = [];
        $dataToReturn['guild_id'] = $guildData['data']['guild_id'];
        $dataToReturn['name'] = $guildData['data']['name'];
        $dataToReturn['galactic_power'] = $guildData['data']['galactic_power'];
        $dataToReturn['member_count'] = $guildData['data']['member_count'];

        if($internal){
            $members = [];
            foreach ($guildData['data']['members'] as $member){
                $memberData = [];
                //$memberMoreData = $this->getPlayerAndGuildData($client, $member["ally_code"]);
                $memberData["pseudo"] = $member["player_name"];
                $memberData["ally_code"] = $member["ally_code"];
                $memberData["galactic_power"] = $member["galactic_power"];
                //$memberData["heroes"] = $memberMoreData['heroes'];
                $memberData["heroes"] = [];
                //$memberData["ships"] = $memberMoreData['ships'];
                $memberData["ships"] = [];
                $members [] = $memberData;
            }
            $dataToReturn["members"] = $members;
        }

        $jsonDataToReturn = json_decode($this->json($dataToReturn)->getContent(), true);
        return new JsonResponse(
            [
                "message" => "some data was found.",
                "data" => $jsonDataToReturn,
            ],
            Response::HTTP_OK
        );
    }


    #[Route('/api/{allyCode}/create', name: 'save_player_in_db', methods: 'POST')]
    public function savePlayerInDb(HttpClientInterface $client, EntityManagerInterface $entityManager, PlayersRepository $playersRepository, string $allyCode) : JsonResponse
    {
        try {

            $playerExist = $playersRepository->findOneBy([
                "allyCode" => $allyCode
            ]);
            if(!$playerExist){
                $data = $this->getPlayerAndGuildData($client, $allyCode);
                $playerData = $data['playerData'];
                $guildData = $data['guildData'];
                $heroes = $data['heroes'];
                $ships = $data['ships'];

                $player = $this->createPlayerEntity($playerData, $guildData, $heroes, $ships, $allyCode);
                $player->setCreatedAt(new \DateTimeImmutable());

                $entityManager->persist($player);
                $entityManager->flush();
                return new JsonResponse(
                    [
                        "message" => "Player was properly add to database.",
                        "data" => json_decode($this->json($player)->getContent(), true),
                    ],
                    Response::HTTP_CREATED
                );
            }

            return new JsonResponse(
                [
                    "message" => "Player alrady exist.",
                    "data" => json_decode($this->json($playerExist)->getContent(), true)
                ],
                Response::HTTP_BAD_REQUEST
            );


        } catch (\Exception $e){
            return new JsonResponse(
                ["message" => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }


    #[Route('/api/{allyCode}/update', name: 'updade_player_in_db', methods: 'PUT')]
    public function updatePlayerInDb(HttpClientInterface $client, EntityManagerInterface $entityManager, string $allyCode) : JsonResponse
    {
        try {
            $data = $this->getPlayerAndGuildData($client, $allyCode);

            $playerData = $data['playerData'];
            $guildData = $data['guildData'];
            $heroes = $data['heroes'];
            $ships = $data['ships'];

            $repository = $entityManager->getRepository(Players::class);

            $player = $repository->findOneBy([
                "allyCode" => $allyCode
            ]);

            if (!$player) {
                return new JsonResponse(
                    ["message" => "Player not found."],
                    Response::HTTP_NOT_FOUND
                );
            }

            $updatedPlayer = $this->createPlayerEntity($playerData, $guildData, $heroes, $ships, $allyCode);

            $player->setPseudo($updatedPlayer->getPseudo());
            $player->setLevel($updatedPlayer->getLevel());
            $player->setTotalGalacticPower($updatedPlayer->getTotalGalacticPower());
            $player->setHeroesGalacticPower($updatedPlayer->getHeroesGalacticPower());
            $player->setShipsGalacticPower($updatedPlayer->getShipsGalacticPower());
            $player->setGuildName($updatedPlayer->getGuildName());
            $player->setHeroes($updatedPlayer->getHeroes());
            $player->setShips($updatedPlayer->getShips());
            $player->setPlayerGuildMemberNb($updatedPlayer->getPlayerGuildMemberNb());
            $player->setOtherPlayersInGuild($updatedPlayer->getOtherPlayersInGuild());
            $player->setUpdatedAt(new \DateTimeImmutable());

            $entityManager->flush();

            return new JsonResponse(
                [
                    "message" => "Player was properly updated",
                    "data" => json_decode($this->json($player)->getContent(), true),
                ],
                Response::HTTP_OK
            );
        } catch (\Exception $e){
            return new JsonResponse(
                ["message" => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    private function createPlayerEntity(array $playerData, array $guildData, array $heroes, array $ships, string $allyCode): Players
    {
        $player = new Players();
        $player->setPseudo($playerData["data"]["name"]);
        $player->setLevel($playerData["data"]["level"]);
        $player->setAllyCode($allyCode);
        $player->setTotalGalacticPower($playerData["data"]["galactic_power"]);
        $player->setHeroesGalacticPower($playerData["data"]["character_galactic_power"]);
        $player->setShipsGalacticPower($playerData["data"]["ship_galactic_power"]);
        $player->setGuildName($guildData["name"]);
        $player->setHeroes($heroes);
        $player->setShips($ships);
        $player->setPlayerGuildMemberNb($guildData["member_count"]);
        $player->setOtherPlayersInGuild($guildData["members"]);
        $player->setUrl("https://swgoh.gg".$playerData["data"]["url"]);
        //$player->setCreatedAt(new \DateTimeImmutable());
        //$player->setUpdatedAt(new \DateTimeImmutable());

        return $player;
    }

    private function getPlayerAndGuildData(HttpClientInterface $client, string $allyCode): array
    {
        $response = $client->request(
            "GET",
            "https://swgoh.gg/api/player/$allyCode/"
        );

        $playerData = $response->toArray();
        $guildJsonData = $this->getGuildByAllyCode($client, $allyCode, true)->getContent();
        $guildData = json_decode($guildJsonData, true);

        $heroes = [];
        $ships = [];
        foreach ($playerData['units'] as $unit) {
            if ($unit['data']['combat_type'] == 1) {
                // if combat_type == 1 -> hero
                $heroes[] = $unit["data"];
            } elseif ($unit['data']['combat_type'] == 2) {
                // if combat_type == 2 -> ship
                $ships[] = $unit["data"];
            }
        }

        return [
            'playerData' => $playerData,
            'guildData' => $guildData,
            'heroes' => $heroes,
            'ships' => $ships,
        ];
    }
}
