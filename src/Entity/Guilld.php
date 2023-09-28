<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;

#[ApiResource(operations: [
    new Get(name: "get_players_by_allyCode", uriTemplate: "/guild/{allyCode}"),
])]
class Guilds {

    private string $allyCode;

}