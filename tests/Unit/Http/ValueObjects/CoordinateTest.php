<?php

namespace Tests\Unit\Http\ValueObjects;

use App\Http\ValueObjects\Coordinate;
use PHPUnit\Framework\TestCase;

class CoordinateTest extends TestCase
{
    public function testCreateCoordinate(): void
    {
        $coordinate = new Coordinate(longitude: 35.6895, latitude: 139.6917);

        $this->assertEquals(35.6895, $coordinate->longitude());
        $this->assertEquals(139.6917, $coordinate->latitude());
    }

    public function testToPoint(): void
    {
        $coordinate = new Coordinate(longitude: 35.6895, latitude: 139.6917);

        $this->assertEquals('SRID=4326;POINT(35.6895 139.6917)', $coordinate->toPoint());
    }
}
