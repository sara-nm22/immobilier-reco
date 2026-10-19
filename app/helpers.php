<?php

if (!function_exists('listing_img')) {

    function listing_img($id, $type = null, $city = null, $neighborhood = null)
    {
        // ✅ Seed SUPER UNIQUE
        $seed = abs(crc32($id . '|' . $type . '|' . $city . '|' . $neighborhood));

        // ✅ Images spécifiques par QUARTIER (ultra réaliste)
        $hoodImages = [
            'Maarif' => [
                "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1600210492493-0946911123ea?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1200&q=80",
            ],
            'Guéliz' => [
                "https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1521783988139-5da7d0dfb8b7?auto=format&fit=crop&w=1200&q=80",
            ],
            'Médina' => [
                "https://images.unsplash.com/photo-1600566753151-384129cf4e3c?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1501183638710-841dd1904471?auto=format&fit=crop&w=1200&q=80",
            ],
            'Ville Nouvelle' => [
                "https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1523217582562-09d0def993a6?auto=format&fit=crop&w=1200&q=80",
            ],
        ];

        // ✅ Images par VILLE (fallback 2)
        $cityImages = [
            'Casablanca' => [
                "https://images.unsplash.com/photo-1523217582562-09d0def993a6?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1200&q=80",
            ],
            'Rabat' => [
                "https://images.unsplash.com/photo-1560185008-5bf9f2849488?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1600210492493-0946911123ea?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1501183638710-841dd1904471?auto=format&fit=crop&w=1200&q=80",
            ],
            'Marrakech' => [
                "https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1521783988139-5da7d0dfb8b7?auto=format&fit=crop&w=1200&q=80",
            ],
            'Tanger' => [
                "https://images.unsplash.com/photo-1600566753151-384129cf4e3c?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=1200&q=80",
            ],
            'Agadir' => [
                "https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1521783988139-5da7d0dfb8b7?auto=format&fit=crop&w=1200&q=80",
            ],
            'Fès' => [
                "https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?auto=format&fit=crop&w=1200&q=80",
            ],
        ];

        // ✅ Images par TYPE (fallback 3)
        $typeImages = [
            'Appartement' => [
                "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1200&q=80",
            ],
            'Villa' => [
                "https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=1200&q=80",
            ],
            'Studio' => [
                "https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1588880331179-bc9b93a8cb5e?auto=format&fit=crop&w=1200&q=80",
            ],
            'Maison' => [
                "https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=1200&q=80",
                "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80",
            ],
        ];

        // ✅ fallback final
        $fallback = [
            "https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1501183638710-841dd1904471?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1200&q=80",
            "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1200&q=80",
        ];

        // ✅ priorité: quartier > ville > type > fallback
        if ($neighborhood && isset($hoodImages[$neighborhood])) {
            $imgs = $hoodImages[$neighborhood];
        } elseif ($city && isset($cityImages[$city])) {
            $imgs = $cityImages[$city];
        } elseif ($type && isset($typeImages[$type])) {
            $imgs = $typeImages[$type];
        } else {
            $imgs = $fallback;
        }

        return $imgs[$seed % count($imgs)];
    }
}
