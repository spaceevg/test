<?php

abstract class CircleAbstract
{
    protected $xOffsetCoordinate;

    protected $yOffsetCoordinate;

    protected $radius = 0;

    protected $step = 1;

    protected $quadrant;

    public function __construct()
    {
        $this->quadrant = sin(deg2rad(45));
    }

    public function print(float $xCoordinate, float $yCoordinate, float $radius, float $step = 1)
    {
        $this->xOffsetCoordinate = $xCoordinate;
        $this->yOffsetCoordinate = $yCoordinate;
        if (!$this->setRadius($radius))
        {
            return 'Некорректное значение радиуса';
        };
        $this->step = $step;
        $this->printPoints();
        return true;
    }

    protected abstract function printPoint(float $xCoordinate, float $yCoordinate);

    private function setRadius(float $radius)
    {
        $isValid = false;
        if ($radius != 0) {
            $this->radius = abs($radius);
            $isValid = true;
        }
        return $isValid;
    }

    private function printPoints()
    {
        $x = 0;
        $maxX = $this->radius * $this->quadrant;
        while($x <= $maxX) {
            $sin = $x / $this->radius;
            $points = [];
            $y = $this->radius * sqrt(1 - ($sin ** 2));
            $points[] = [
                'x' => $x + $this->xOffsetCoordinate, 
                'y' => $y + $this->yOffsetCoordinate
            ];
            $points[] = [
                'x' => $x + $this->xOffsetCoordinate, 
                'y' => -$y + $this->yOffsetCoordinate
            ];
            $points[] = [
                'y' => $x + $this->yOffsetCoordinate, 
                'x' => -$y + $this->xOffsetCoordinate
            ];
            $points[] = [
                'y' => $x + $this->yOffsetCoordinate, 
                'x' => $y + $this->xOffsetCoordinate
            ];

            if (($x != 0) && ($x != $y)) {
                $points[] = [
                    'y' => -$x + $this->yOffsetCoordinate, 
                    'x' => $y + $this->xOffsetCoordinate
                ];
                $points[] = [
                    'y' => -$x + $this->yOffsetCoordinate, 
                    'x' => -$y + $this->xOffsetCoordinate
                ];
                $points[] = [
                    'x' => -$x + $this->xOffsetCoordinate, 
                    'y' => $y + $this->yOffsetCoordinate
                ];
                $points[] = [
                    'x' => -$x + $this->xOffsetCoordinate, 
                    'y' => -$y + $this->yOffsetCoordinate
                ];
            }

            foreach ($points as $point) {
                $this->printPoint($point['x'], $point['y']);
            }

            $x += $this->step;
        }
    }
}
 