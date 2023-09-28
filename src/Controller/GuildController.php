<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GuildController extends AbstractController
{
    #[Route('/api/guild/{allyCode}', name: 'get_guild_by_allyCode', methods: ['GET'])]
    public function index(HttpClientInterface $client, string $allyCode): JsonResponse
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

        // Identifiant unique de la
        // guilde : guild_id
        // ▪ Nom de la guilde : name
        // ▪ Puissance Galactique, : galactic_power
        // ▪ Nombre de joueurs dans la
        // guilde. : member_count

        $guildData = $guildResponse->toArray();

        $dataToReturn = [];
        $dataToReturn['guild_id'] = $guildData['data']['guild_id'];
        $dataToReturn['name'] = $guildData['data']['name'];
        $dataToReturn['galactic_power'] = $guildData['data']['galactic_power'];
        $dataToReturn['member_count'] = $guildData['data']['member_count'];
        
        return new JsonResponse([
            'result' => $dataToReturn,
            'status' => 200
        ]);
    }
}
