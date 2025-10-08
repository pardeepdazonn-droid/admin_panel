<?php


$warehouse_address = "Connaught Place, New Delhi, India";
$rate_per_km = 1;
$use_road_distance = true; 

if (!isset($address)) {
    die("Error: Customer address not provided.");
}

function getCoordinates($address) {
    $url = "https://nominatim.openstreetmap.org/search?q=" . urlencode($address) . "&format=json&limit=1";
    $opts = [
        "http" => [
            "header" => "User-Agent: PHP-Shipping-App/1.0\r\n"
        ]
    ];
    $context = stream_context_create($opts);
    $response = file_get_contents($url, false, $context);
    $data = json_decode($response, true);

    if (!empty($data)) {
        return [
            "lat" => floatval($data[0]['lat']),
            "lng" => floatval($data[0]['lon'])
        ];
    } else {
        return false;
    }
}

// Haversine formula
function haversineDistance($lat1, $lng1, $lat2, $lng2) {
    $earth_radius = 6371; // km
    $dLat = deg2rad($lat2 - $lat1);
    $dLng = deg2rad($lng2 - $lng1);
    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLng/2) * sin($dLng/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $earth_radius * $c;
}

 
function getRoadDistance($lat1, $lng1, $lat2, $lng2) {
    $url = "http://router.project-osrm.org/route/v1/driving/$lng1,$lat1;$lng2,$lat2?overview=false";
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    if (!empty($data['routes'][0]['distance'])) {
        return $data['routes'][0]['distance'] / 1000; // km
    }
    return false;
}

 
$full_address = implode(', ', array_filter([
    $address['address_line1'] ?? '',
    $address['address_line2'] ?? '',
    $address['city'] ?? '',
    $address['state'] ?? '',
    $address['postal_code'] ?? '',
    $address['country'] ?? ''
]));

 
$customer_coords = getCoordinates($full_address);

 
if (!$customer_coords) {
    $fallback_address = implode(', ', array_filter([
        $address['city'] ?? '',
        $address['state'] ?? '',
        $address['postal_code'] ?? ''
    ]));
    $customer_coords = getCoordinates($fallback_address);
}
 
$warehouse_coords = getCoordinates($warehouse_address);
if (!$customer_coords) {
    $customer_coords = $warehouse_coords;
}
 
if ($use_road_distance) {
    $distance_km = getRoadDistance(
        $warehouse_coords['lat'],
        $warehouse_coords['lng'],
        $customer_coords['lat'],
        $customer_coords['lng']
    );
    if ($distance_km === false) {
        $distance_km = haversineDistance(
            $warehouse_coords['lat'],
            $warehouse_coords['lng'],
            $customer_coords['lat'],
            $customer_coords['lng']
        );
    }
} else {
    $distance_km = haversineDistance(
        $warehouse_coords['lat'],
        $warehouse_coords['lng'],
        $customer_coords['lat'],
        $customer_coords['lng']
    );
}
$shipping_fee = $distance_km * $rate_per_km;
?>
