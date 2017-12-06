<?php

namespace App\Console\Commands;

/**
 * Class Day5Puzzle2
 *
 * @package App\Console\Commands
 */
class Day5Puzzle2 extends Day5Puzzle1
{
    protected $puzzle = '2';

    protected $test = '';
    protected $move = 0;
    protected $pointer = 0;
    protected $totalMoves = 0;

    public function performMove()
    {
        /*
         * if the offset was three or more, instead decrease it by 1. Otherwise, increase it by 1 as before.
         */
        $this->totalMoves++;
        if ($this->move >= 3) {
            $this->test[$this->pointer]--;
        } else {
            $this->test[$this->pointer]++;
        }
        $this->pointer += $this->move;
    }
}
