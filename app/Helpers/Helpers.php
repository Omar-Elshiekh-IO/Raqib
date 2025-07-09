<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
class Helpers
{

  public static function haversineDistance($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371000; // in meters

    $lat1 = deg2rad($lat1);
    $lat2 = deg2rad($lat2);
    $deltaLat = $lat2 - $lat1;
    $deltaLon = deg2rad($lon2 - $lon1);

    $a = sin($deltaLat / 2) ** 2 +
         cos($lat1) * cos($lat2) *
         sin($deltaLon / 2) ** 2;

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earthRadius * $c;
}


}