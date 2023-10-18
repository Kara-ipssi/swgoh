<?php 

namespace App\Service;

use App\Entity\Units;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class UnitsServices
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface $logger,
        private readonly GlobalServices $globalServices,
        private readonly SerializerInterface $serializer
    )
    {}

    public function getAllUnits()
    {
        $units = $this->entityManager->getRepository(Units::class)->findAll();

        if(!$units){
            $units = $this->saveAllUnit();
        }
        return $units;
    }

    public function saveAllUnit()
    {
        try {
            $units = $this->fetchUnitsFromAPI();
            $this->saveUnitsToDatabase($units);
            return $this->entityManager->getRepository(Units::class)->findAll();
        }catch (\Exception $e){
            return $this->globalServices->prepareErrorJsonResponse($e->getMessage());
        }
    }

    private function fetchUnitsFromAPI() : array
    {
        $url1 = "https://swgoh.gg/api/characters/";
        $url2 = "https://swgoh.gg/api/ships/";
        $responseHeroes = $this->globalServices->getApi($url1);
        $responseShips = $this->globalServices->getApi($url2);
        return array_merge($responseHeroes, $responseShips);
    }

    private function saveUnitsToDatabase(array $unitList)
    {
        foreach ($unitList as $unitItem) {
            $unit = $this->createUnitEntity($unitItem);
            $this->entityManager->persist($unit);
        }
        $this->entityManager->flush();
    }

    public function saveOneUnit(array $unit) : Units | JsonResponse
    {
        try {
            $newUnit = $this->createUnitEntity($unit);
            $this->entityManager->persist($newUnit);
            $this->entityManager->flush();
            return $newUnit;
        } catch (\Exception $e) {
            return $this->globalServices->prepareErrorJsonResponse($e->getMessage());
        }
    }

    public function createUnitEntity(array $unitData): Units
    {
        $unit = new Units();
        $unit->setName($unitData["name"]);
        $unit->setBaseId($unitData["base_id"]);
        $unit->setUrl("https://swgoh.gg".$unitData["url"]);
        $unit->setPower($unitData["power"]);
        $unit->setCombatType($unitData["combat_type"]);
        $unit->setImage($unitData["image"]);
        return $unit;
    }
}