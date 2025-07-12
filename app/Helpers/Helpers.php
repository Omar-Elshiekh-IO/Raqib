<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
class Helpers
{

  public static function haversineDistance($empLat, $empLon, $branchLat, $branchLon)
{
    $earthRadius = 6371000; // in meters

    $empLat = deg2rad($empLat);
    $branchLat = deg2rad($branchLat);
    $deltaLat = $branchLat - $empLat;
    $deltaLon = deg2rad($branchLon - $empLon);

    $a = sin($deltaLat / 2) ** 2 +
         cos($empLat) * cos($branchLat) *
         sin($deltaLon / 2) ** 2;

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $earthRadius * $c;
}


}