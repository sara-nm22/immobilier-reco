<?php

namespace App\Http\Controllers;

use App\Services\Neo4jService;

class FavoriteController extends Controller
{
    public function index(Neo4jService $neo)
    {
        $userId = auth()->user()?->neo4j_id;

        if (!$userId) {
            return view('favorites.index', ['favorites' => []]);
        }

        // ✅ récupérer favoris triés par date DESC
        $result = $neo->run("
            MATCH (u:users {id:\$userId})-[r:FAVORITED]->(l:listing)
            RETURN l, r.ts AS ts
            ORDER BY ts DESC
        ", ['userId' => $userId]);

        $favorites = [];

        foreach ($result as $row) {
            $listing = $row->get('l')->getProperties();
            $ts = $row->get('ts');

            $favorites[] = [
                'listing' => $listing,
                'ts' => method_exists($ts, 'toDateTime')
                    ? $ts->toDateTime()->format('Y-m-d H:i')
                    : (string) $ts,
            ];
        }

        return view('favorites.index', compact('favorites'));
    }

    public function store($listingId, Neo4jService $neo)
    {
        $userId = auth()->user()?->neo4j_id;

        if (!$userId) {
            return back()->with('error', 'Ajoute ton neo4j_id dans ton profil ❗');
        }

        // ✅ MERGE favori (évite doublons) + met à jour ts
        $neo->run("
            MATCH (u:users {id:\$userId})
            MATCH (l:listing {id:\$listingId})
            MERGE (u)-[r:FAVORITED]->(l)
            SET r.ts = datetime()
        ", [
            'userId' => $userId,
            'listingId' => $listingId
        ]);

        return back()->with('success', 'Ajouté aux favoris ✅');
    }

    public function destroy($listingId, Neo4jService $neo)
    {
        $userId = auth()->user()?->neo4j_id;

        if (!$userId) {
            return back()->with('error', 'Ajoute ton neo4j_id dans ton profil ❗');
        }

        $neo->run("
            MATCH (u:users {id:\$userId})-[r:FAVORITED]->(l:listing {id:\$listingId})
            DELETE r
        ", [
            'userId' => $userId,
            'listingId' => $listingId
        ]);

        return back()->with('success', 'Retiré des favoris ❌');
    }
}
