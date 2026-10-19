<?php

namespace App\Http\Controllers;

use App\Services\Neo4jService;

class HistoryController extends Controller
{
    public function index(Neo4jService $neo)
    {
        $userId = auth()->user()?->neo4j_id;

        if (!$userId) {
            return view('history.index', ['history' => []]);
        }

        // ✅ récupérer historique VIEWED trié par date
        $result = $neo->run("
            MATCH (u:users {id:\$userId})-[r:VIEWED]->(l:listing)
            RETURN l, r.ts AS ts
            ORDER BY ts DESC
            LIMIT 50
        ", ['userId' => $userId]);

        $history = [];

        foreach ($result as $row) {
            $listing = $row->get('l')->getProperties();
            $ts = $row->get('ts');

            // ✅ convertir ts proprement (Laudis DateTime)
            $history[] = [
                'listing' => $listing,
                'ts' => method_exists($ts, 'toDateTime')
                    ? $ts->toDateTime()->format('Y-m-d H:i')
                    : (string) $ts,
            ];
        }

        return view('history.index', compact('history'));
    }
}
