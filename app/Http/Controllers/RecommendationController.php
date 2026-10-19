<?php

namespace App\Http\Controllers;

use App\Services\Neo4jService;

class RecommendationController extends Controller
{
    public function index(Neo4jService $neo)
    {
        $userId = auth()->user()?->neo4j_id;

        if (!$userId) {
            return view("recommendations.index", [
                "recommendations" => [],
                "mode" => "none"
            ]);
        }

        // ✅ Niveau 1: Collaborative filtering
        $result = $neo->run("
            MATCH (u:users {id:\$userId})-[:FAVORITED]->(l:listing)
            MATCH (other:users)-[:FAVORITED]->(l)
            WHERE other.id <> u.id
            MATCH (other)-[:FAVORITED]->(rec:listing)
            WHERE NOT (u)-[:FAVORITED]->(rec)
            RETURN rec AS listing, COUNT(*) AS score
            ORDER BY score DESC
            LIMIT 12
        ", ['userId' => $userId]);

        $recommendations = [];
        foreach ($result as $row) {
            $recommendations[] = [
                'listing' => $row->get('listing')->getProperties(),
                'score'   => $row->get('score')
            ];
        }

        // ✅ Niveau 2: Content-based si vide
        if (count($recommendations) == 0) {

            $budgetMin = auth()->user()->budgetMin ?? 0;
            $budgetMax = auth()->user()->budgetMax ?? 999999;

            $result = $neo->run("
                MATCH (u:users {id:\$userId})-[:FAVORITED]->(l:listing)
                WITH u, collect(l.city) AS cities, collect(l.type) AS types
                MATCH (rec:listing)
                WHERE rec.city IN cities
                  AND rec.type IN types
                  AND rec.price >= \$budgetMin
                  AND rec.price <= \$budgetMax
                  AND NOT (u)-[:FAVORITED]->(rec)
                RETURN rec AS listing, 1 AS score
                ORDER BY rec.price ASC
                LIMIT 12
            ", [
                "userId" => $userId,
                "budgetMin" => (int)$budgetMin,
                "budgetMax" => (int)$budgetMax,
            ]);

            foreach ($result as $row) {
                $recommendations[] = [
                    'listing' => $row->get('listing')->getProperties(),
                    'score'   => 1
                ];
            }

            $mode = "content";
        } else {
            $mode = "collab";
        }

        // ✅ Niveau 3: fallback global si toujours vide
        if (count($recommendations) == 0) {

            $result = $neo->run("
                MATCH (u:users {id:\$userId})
                MATCH (rec:listing)
                WHERE NOT (u)-[:FAVORITED]->(rec)
                RETURN rec AS listing, rec.price AS score
                ORDER BY rec.price ASC
                LIMIT 12
            ", ['userId' => $userId]);

            foreach ($result as $row) {
                $recommendations[] = [
                    'listing' => $row->get('listing')->getProperties(),
                    'score'   => 0
                ];
            }

            $mode = "fallback";
        }

        return view("recommendations.index", compact("recommendations", "mode"));
    }
}
