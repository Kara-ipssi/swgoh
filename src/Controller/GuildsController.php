<?php

namespace App\Controller;

use App\Service\GlobalServices;
use App\Service\GuildsServices;
use App\Service\PlayersServices;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GuildsController extends AbstractController
{
    public function __construct(
        private readonly GuildsServices $guildsServices,
        private readonly GlobalServices $globalServices,
        private readonly PlayersServices $playersServices,
    )
    {}

    #[Route('/api/{allyCode}/guild', name: 'get_guild_by_allyCode')]
    public function getGuildByAllyCode( string $allyCode, bool $internal = false): JsonResponse
    {   
        $data = $this->playersServices->getPlayer($allyCode);
        $guild = $data["playerData"]->getGuild();
        $groups = ['groups' => ['playerData']];
        return $this->globalServices->prepareJsonResponse($guild, $groups);
    }
}
