<?php

namespace App\Console\Commands;

/**
 * Class Day15Puzzle2
 *
 * @package App\Console\Commands
 */
class Day15Puzzle2 extends Day15Puzzle1
{
    protected $puzzle = '2';
    public $repeat = 5000000;
    public $multiple = ['A' => 4, 'B' => 8];

    public function generate($generator)
    {
        $this->generator[$generator] = ($this->generator[$generator] * $this->factor[$generator]) % self::DIV;
        if ($this->generator[$generator] % $this->multiple[$generator] != 0) {
            return $this->generate($generator);
        }
        return $this->generator[$generator];
    }
}
