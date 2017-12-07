<?php

namespace App\Console\Commands;

/**
 * Class Day6Puzzle2
 *
 * @package App\Console\Commands
 */
class Day6Puzzle2 extends Day6Puzzle1
{
    protected $day = 6;
    protected $puzzle = '2';
    protected $inputs = '{test?}';

    protected $loops = 11137;
    protected $endState = [14, 13, 12, 11, 9, 8, 8, 6, 6, 4, 4, 3, 1, 1, 0, 12];

    public function checkStates()
    {
        if ($this->test == $this->endState) {
            $this->result = $this->loops - $this->result;
            return false;
        } else {
            $this->states[] = $this->test;
            return true;
        }
    }
}
