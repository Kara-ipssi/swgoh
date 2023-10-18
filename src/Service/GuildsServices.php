<?php

namespace App\Service;

use App\Entity\Guilds;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class GuildsServices
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface $logger,
        private readonly GlobalServices $globalServices,
    )
    {}

    public function getGuild(string $guildId) : Guilds
    {
        $guild = $this->entityManager->getRepository(Guilds::class)->findOneById($guildId);
        if(!$guild){
            $guild = $this->saveGuild($guildId);
        }
        return $guild;
    }

    public function saveGuild(string $guildId) : Guilds | JsonResponse
    {
        $url = "https://swgoh.gg/api/guild-profile/".$guildId;
        $guild = new Guilds();
        try {
            $guildData = $this->globalServices->getApi($url)['data'];
            $guild->setId($guildData['guild_id']);
            $guild->setName($guildData['name']);
            $guild->setGalacticPower($guildData['galactic_power']);
            $guild->setMemberCount($guildData['member_count']);
            $this->entityManager->persist($guild);
            $this->entityManager->flush();
            return $guild;
        } catch (\Throwable $e) {
            return $this->globalServices->prepareErrorJsonResponse($e->getMessage());
        }
    }

    public function removeGuild(string $guildId) : JsonResponse
    {
        try {
            $guild = $this->entityManager->getRepository(Guilds::class)->findOneById($guildId);
            if(!$guild){
                return $this->globalServices->prepareErrorJsonResponse("Guild not found");
            }
            $this->entityManager->remove($guild);
            $this->entityManager->flush();
            return $this->globalServices->prepareJsonResponse("Guild removed");
        } catch (\Throwable $e) {
            return $this->globalServices->prepareErrorJsonResponse($e->getMessage());
        }
    }
}
