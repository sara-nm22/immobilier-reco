<?php

namespace App\Http\Controllers;

use App\Services\Neo4jService;

class DashboardController extends Controller
{
    public function index(Neo4jService $neo)
    {
        $user = auth()->user();
        $userId = $user?->neo4j_id;

        $stats = [
            'viewed' => 0,
            'favorites' => 0,
            'recos' => 0,
        ];

        $topRecs = [];
        $mode = "none";

        if ($userId) {

            // ✅ Stat viewed
            $stats['viewed'] = $neo->run("
                MATCH (:users {id:\$userId})-[r:VIEWED]->(:listing)
                RETURN COUNT(r) AS c
            ", ['userId' => $userId])->first()->get('c');

            // ✅ Stat favorites
            $stats['favorites'] = $neo->run("
                MATCH (:users {id:\$userId})-[r:FAVORITED]->(:listing)
                RETURN COUNT(r) AS c
            ", ['userId' => $userId])->first()->get('c');

            // ✅ ---- TOP Recommendations ----
            $recommendations = [];

            // ✅ 1) Collaborative
            $result = $neo->run("
                MATCH (u:users {id:\$userId})-[:FAVORITED]->(l:listing)
                MATCH (other:users)-[:FAVORITED]->(l)
                WHERE other.id <> u.id
                MATCH (other)-[:FAVORITED]->(rec:listing)
                WHERE NOT (u)-[:FAVORITED]->(rec)
                RETURN rec AS listing, COUNT(*) AS score
                ORDER BY score DESC
                LIMIT 3
            ", ['userId' => $userId]);

            foreach ($result as $row) {
                $recommendations[] = [
                    'listing' => $row->get('listing')->getProperties(),
                    'score'   => $row->get('score'),
                ];
            }

            if (count($recommendations) > 0) {
                $mode = "collab";
            }

            // ✅ 2) Content-Based
            if (count($recommendations) == 0) {
                $budgetMin = $user->budgetMin ?? 0;
                $budgetMax = $user->budgetMax ?? 999999;

                $result = $neo->run("
                    MATCH (u:users {id:\$userId})-[:FAVORITED]->(l:listing)
                    WITH u, collect(l.city) AS cities, collect(l.type) AS types
                    MATCH (rec:listing)
                    WHERE rec.city IN cities
                      AND rec.type IN types
                      AND rec.price >= \$budgetMin
                      AND rec.price <= \$budgetMax
                      AND NOT (u)-[:FAVORITED]->(rec)
                    RETURN rec AS listing, 2 AS score
                    ORDER BY rec.price ASC
                    LIMIT 3
                ", [
                    "userId" => $userId,
                    "budgetMin" => (int)$budgetMin,
                    "budgetMax" => (int)$budgetMax,
                ]);

                foreach ($result as $row) {
                    $recommendations[] = [
                        'listing' => $row->get('listing')->getProperties(),
                        'score'   => $row->get('score'),
                    ];
                }

                if (count($recommendations) > 0) {
                    $mode = "content";
                }
            }

            // ✅ 3) VIEWED-Based
            if (count($recommendations) == 0) {

                $result = $neo->run("
                    MATCH (u:users {id:\$userId})-[v:VIEWED]->(l:listing)
                    WITH u, l.city AS city, l.type AS type, COUNT(v) AS freq
                    ORDER BY freq DESC
                    LIMIT 1

                    MATCH (rec:listing)
                    WHERE rec.city = city
                      AND rec.type = type
                      AND NOT (u)-[:FAVORITED]->(rec)
                    RETURN rec AS listing, freq AS score
                    ORDER BY rec.price ASC
                    LIMIT 3
                ", ['userId' => $userId]);

                foreach ($result as $row) {
                    $recommendations[] = [
                        'listing' => $row->get('listing')->getProperties(),
                        'score'   => $row->get('score'),
                    ];
                }

                if (count($recommendations) > 0) {
                    $mode = "viewed";
                }
            }

            $topRecs = $recommendations;
            $stats['recos'] = count($topRecs);
        }

        return view('dashboard', compact('stats', 'topRecs', 'mode'));
    }
}
