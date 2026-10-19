<?php

namespace App\Http\Controllers;

use App\Services\Neo4jService;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index(Request $request, Neo4jService $neo)
    {
        // ✅ dropdown villes
        $citiesResult = $neo->run("MATCH (l:listing) RETURN DISTINCT l.city AS city ORDER BY city");
        $cities = [];
        foreach ($citiesResult as $row) {
            $cities[] = $row->get('city');
        }

        // ✅ dropdown types
        $typesResult = $neo->run("MATCH (l:listing) RETURN DISTINCT l.type AS type ORDER BY type");
        $types = [];
        foreach ($typesResult as $row) {
            $types[] = $row->get('type');
        }

        // ✅ Query dynamique
        $query = "MATCH (l:listing) ";
        $where = [];
        $params = [];

        if ($request->filled('city')) {
            $where[] = "l.city = \$city";
            $params['city'] = $request->city;
        }

        if ($request->filled('type')) {
            $where[] = "l.type = \$type";
            $params['type'] = $request->type;
        }

        if ($request->filled('rooms')) {
            $where[] = "l.rooms = \$rooms";
            $params['rooms'] = (int) $request->rooms;
        }

        if ($request->filled('min_price')) {
            $where[] = "l.price >= \$min_price";
            $params['min_price'] = (int) $request->min_price;
        }

        if ($request->filled('max_price')) {
            $where[] = "l.price <= \$max_price";
            $params['max_price'] = (int) $request->max_price;
        }

        if ($request->filled('min_area')) {
            $where[] = "l.area >= \$min_area";
            $params['min_area'] = (int) $request->min_area;
        }

        if ($request->filled('max_area')) {
            $where[] = "l.area <= \$max_area";
            $params['max_area'] = (int) $request->max_area;
        }

        if (!empty($where)) {
            $query .= "WHERE " . implode(" AND ", $where) . " ";
        }

        $query .= "RETURN l ORDER BY l.price ASC LIMIT 30";

        $result = $neo->run($query, $params);

        $listings = [];
        foreach ($result as $row) {
            $listings[] = $row->get('l')->getProperties();
        }

        return view('listings.index', compact('listings', 'cities', 'types'));
    }

    public function show($id, Neo4jService $neo)
    {
        $userId = auth()->user()?->neo4j_id;

        // ✅ récupérer listing
        $result = $neo->run("
            MATCH (l:listing {id:\$listingId})
            RETURN l
            LIMIT 1
        ", ['listingId' => $id]);

        if ($result->count() == 0) {
            abort(404, "Listing not found");
        }

        $listing = $result->first()->get('l')->getProperties();

        // ✅ enregistrer VIEWED (MERGE pour éviter redondance)
        if ($userId) {
            $neo->run("
                MATCH (u:users {id:\$userId})
                MATCH (l:listing {id:\$listingId})
                MERGE (u)-[r:VIEWED]->(l)
                SET r.ts = datetime()
            ", [
                'userId' => $userId,
                'listingId' => $id
            ]);
        }

        // ✅ images gallery (réelles depuis neo4j)
        $images = $listing['images'] ?? [];

        if (empty($images)) {
            $images = [
                listing_img($listing['id'], $listing['type'], $listing['city'], $listing['neighborhood']),
            ];
        }

        // ✅ Similar listings (même ville + type)
        $simResult = $neo->run("
            MATCH (l:listing {id:\$listingId})
            MATCH (s:listing)
            WHERE s.id <> l.id
              AND s.city = l.city
              AND s.type = l.type
            RETURN s
            ORDER BY abs(s.price - l.price) ASC
            LIMIT 6
        ", ['listingId' => $id]);

        $similar = [];
        foreach ($simResult as $row) {
            $similar[] = $row->get('s')->getProperties();
        }

        return view('listings.show', compact('listing', 'images', 'similar'));
    }
}
