<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GlobalServices
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly LoggerInterface $logger,
        private readonly SerializerInterface $serializer,
        private readonly EntityManagerInterface $entityManager,
    )
    {}

    

    public function getHttpClient() : HttpClientInterface
    {
        return $this->client;
    }

    public function getApi(string $url) : array
    {
        $response = $this->client->request("GET", $url);
        $data = $response->toArray();
        return $data;
    }

    public function prepareJsonResponse(mixed $dataToReturn = [], array $groups = [], int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse($this->serializer->serialize($dataToReturn, 'json', $groups), $statusCode, [], true);
    }

    public function prepareErrorJsonResponse(string $message, int $statusCode = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return new JsonResponse($this->serializer->serialize($message, 'json'), $statusCode, [], true);
    }

    public function serializeData(mixed $dataToSerialize, array $groups = []): string
    {
        return $this->serializer->serialize($dataToSerialize, 'json', $groups);
    }

}

