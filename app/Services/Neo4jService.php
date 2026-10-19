<?php

namespace App\Services;

use Laudis\Neo4j\ClientBuilder;
use Laudis\Neo4j\Authentication\Authenticate;

class Neo4jService
{
    protected $client;

    public function __construct()
    {
        $uri = env('NEO4J_URI');
        $user = env('NEO4J_USER');
        $password = env('NEO4J_PASSWORD');

        $this->client = ClientBuilder::create()
            ->withDriver('neo4j', $uri, Authenticate::basic($user, $password))
            ->build();
    }

    public function run(string $query, array $params = [])
    {
        return $this->client->run($query, $params);
    }
}
