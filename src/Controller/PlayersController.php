<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use App\Service\GlobalServices;
use App\Repository\PlayersRepository;
use App\Service\PlayersServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlayersController extends AbstractController
{

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly HttpClientInterface $client,
        private readonly EntityManagerInterface $entityManager,
        private readonly PlayersRepository $playersRepository,
        private readonly GlobalServices $globalServices,
        private readonly PlayersServices $playersServices,
    ) {}

    #[Route('/api/{allyCode}/create', name: 'save_player_in_db', methods: 'POST')]
    // #[Route('/api/{allyCode}/create', name: 'save_player_in_db', methods: 'GET')]
    public function getPlayerData(string $allyCode)
    {
        $player = $this->playersServices->getPlayer($allyCode);
        $groups = ['groups' => ['playerData']];
        return $this->globalServices->prepareJsonResponse($player, $groups);
    }

    #[Route('/api/{allyCode}/update', name: 'updade_player_in_db', methods: 'PUT')]
    // #[Route('/api/{allyCode}/update', name: 'updade_player_in_db', methods: 'GET')]
    public function updatePlayerData(string $allyCode) : JsonResponse
    {
        $player = $this->playersServices->updatePlayer($allyCode);
        $groups = ['groups' => ['playerData']];
        return $this->globalServices->prepareJsonResponse($player, $groups);
    }
}
