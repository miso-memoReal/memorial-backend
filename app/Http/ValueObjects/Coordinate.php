<?php

namespace App\Http\ValueObjects;

class Coordinate
{
    private float $longitude;

    private float $latitude;

    public function __construct(float $longitude, float $latitude)
    {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    public function longitude(): float
    {
        return $this->longitude;
    }

    public function latitude(): float
    {
        return $this->latitude;
    }

    public function toPoint(): string
    {
        return 'SRID=4326;POINT('.$this->longitude.' '.$this->latitude.')';
    }
}
