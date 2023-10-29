<?php

namespace App\Http\ValueObjects;

class Coordinate
{
    private float $x;

    private float $y;

    public function __construct(float $x, float $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function x(): float
    {
        return $this->x;
    }

    public function y(): float
    {
        return $this->y;
    }

    public function toPoint(): string
    {
        return 'SRID=4326;POINT('.$this->x.' '.$this->y.')';
    }
}
