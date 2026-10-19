<?php

namespace App\Http\Controllers;

use App\Services\Neo4jService;

class HomeController extends Controller
{
    public function index(Neo4jService $neo)
    {
        $result = $neo->run("
            MATCH (:users)-[r:FAVORITED]->(l:listing)
            RETURN l, COUNT(r) AS score
            ORDER BY score DESC
            LIMIT 6
        ");

        $popularListings = [];

        foreach ($result as $row) {
            $popularListings[] = [
                'listing' => $row->get('l')->getProperties(),
                'score'   => $row->get('score'),
            ];
        }

        return view('welcome', compact('popularListings'));
    }
}
