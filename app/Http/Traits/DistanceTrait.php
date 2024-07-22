<?php

namespace App\Http\Traits;

trait DistanceTrait {

    public function calculateDistanceInMeters($lat1, $lng1, $lat2, $lng2) {
        $earthRadius = 6371000; // meters

        $latFrom = deg2rad($lat1);
        $lngFrom = deg2rad($lng1);
        $latTo = deg2rad($lat2);
        $lngTo = deg2rad($lng2);

        $latDelta = $latTo - $latFrom;
        $lngDelta = $lngTo - $lngFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lngDelta / 2), 2)));

        return $angle * $earthRadius;
    }
}
