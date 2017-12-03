<?php

namespace App\Console\Commands;

/**
 * Class Day3Puzzle1
 * Each square on the grid is allocated in a spiral pattern starting at a location marked 1 and then counting up
 *      while spiraling outward. For example, the first few squares are allocated like this:

    17  16  15  14  13
    18   5   4   3  12
    19   6   1   2  11
    20   7   8   9  10
    21  22  23---> ...
    While this is very space-efficient (no squares are skipped), requested data must be carried back to square 1
           (the location of the only access port for this memory system) by programs that can only move up, down, left, or right. They always take the shortest path: the Manhattan Distance between the location of the data and square 1.

    For example:

    Data from square 1 is carried 0 steps, since it's at the access port.
    Data from square 12 is carried 3 steps, such as: down, left, left.
    Data from square 23 is carried only 2 steps: up twice.
    Data from square 1024 must be carried 31 steps.
    How many steps are required to carry the data from the square identified in your puzzle input all the way
           to the access port?
 *
 * @package App\Console\Commands
 */
class Day3Puzzle1 extends AdventCommand
{
    protected $day = 3;
    protected $puzzle = 1;
    protected $inputs = '{test?}';

    protected $default = 368078;

    protected $test = '';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->test = $this->getTestInput('test', $this->default);
        $this->info('Input: ' . $this->test);

        $nearestSquare = $this->findSquare($this->test);
        $halfSquare = floor(sqrt($nearestSquare)/2);
        $this->info('Nearest Square: ' . $nearestSquare);
        $this->info('Square Root: ' . sqrt($nearestSquare));
        $corner = ($nearestSquare - sqrt($nearestSquare) + 1);
        $this->info('Corner: ' . $corner);
        $comparison = ($corner >= $this->test) ? $corner : $nearestSquare;
        $this->info('Compare From: ' . $comparison);

        $evenAdjustment = 0;
        if ($nearestSquare%2 === 0) {
            //because 1 is always the the lower left of the square, even numbered squares need to be offset a little
            $evenTest = abs($nearestSquare - sqrt($nearestSquare) - $this->test);
            if ($comparison == $nearestSquare && $evenTest <= sqrt($nearestSquare) / 2) {
                $evenAdjustment = 2;
            } elseif ($comparison != $nearestSquare) {
                $evenAdjustment = 1;
            }
        }

        //offset is the distance from the center of the row/column
        $offset = ($comparison-($halfSquare))-$this->test;
        //distance of the corner of a square is always sqrt-1, add the offset
        // and any adjustment from being in the top-right or on the rhs of an even square
        $distance = (sqrt($nearestSquare)-1) + (abs($offset)-$halfSquare) + $evenAdjustment;
        $this->info('Output: ' . $distance);
        return 0;
    }

    /**
     * @param int $int
     * @param int $dir 1 or -1
     * @return int
     */
    private function findSquare($int, $dir = 1)
    {
        list($whole, $decimal) = sscanf(sqrt($int), '%d.%d');
        while(!empty($decimal)) {
            return $this->findSquare($int + $dir, $dir);
        }
        return $int;
    }
}
