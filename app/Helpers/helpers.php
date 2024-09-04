<?php

if (!function_exists('haversineDistance')) {
    /**
     * Calculate the distance between two coordinates using the Haversine formula.
     *
     * @param float $lat1 Latitude of the first point.
     * @param float $lon1 Longitude of the first point.
     * @param float $lat2 Latitude of the second point.
     * @param float $lon2 Longitude of the second point.
     * @param float $radius Earth's radius in kilometers. Defaults to Earth's average radius (6371 km).
     * @return float Distance between the two points in kilometers.
     */
    function haversineDistance($lat1, $lon1, $lat2, $lon2, $radius = 6371.0)
    {
        // Haversine formula implementation
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $latDelta = $lat2 - $lat1;
        $lonDelta = $lon2 - $lon1;

        $a = sin($latDelta / 2) ** 2 +
             cos($lat1) * cos($lat2) * sin($lonDelta / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $radius * $c;
    }
}
