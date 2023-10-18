<?php

namespace App\Controller;

use App\Service\GlobalServices;
use App\Service\UnitsServices;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UnitsController extends AbstractController
{

    public function __construct(
        private readonly GlobalServices $globalServices,
        private readonly UnitsServices $unitsServices,
    )
    {}

    #[Route("/api/allHeroesAndShips", name: "get_all_game_heroes", methods: 'GET')]
    public function getAllGameHeroesAndShips(): JsonResponse
    {
        $groups = ['groups' => ['playerData']];
        $units = $this->unitsServices->getAllUnits();
        return $this->globalServices->prepareJsonResponse($units, $groups);
    }
}
