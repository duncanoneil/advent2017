<?php

namespace App\Console\Commands;

/**
 * Class Day3Puzzle1a
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
class Day3Puzzle1a extends AdventCommand
{
    protected $day = 3;
    protected $puzzle = '1a';
    protected $inputs = '{test?}';

    protected $default = 368078;

    protected $test = '';
    protected $memory = [];
    protected $memorySize = 0;
    protected $traversal = [];
    protected $memX = 0;
    protected $memY = 0;

    const ORDER = ['right', 'up', 'left', 'down'];
    const TRANSFORM = ['right' => [1,0], 'up' => [0,1], 'left' => [-1,0], 'down' => [0,-1]];

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

        $this->makeTraversalArray();
//        $this->info('Traversal Rules: ' . print_r($this->traversal, true));
        $this->traverseMemory($this->test);

        $distance = abs($this->memX) + abs($this->memY);

        $this->info('Distance: ' . $distance);
        return 0;
    }

    private function traverseMemory($to) {
        $this->memX = 0;
        $this->memY = 0;
        $traversalArrayPos = 0;
        $steps = 0;
//        $this->info( '1: ' . $this->memX . ', ' . $this->memY);
        for ($i = 2; $i <= $to; $i++) {
//            $this->info($i . ': ' . print_r($this->traversal[$traversalArrayPos]['transform'], true));
            $this->memX += $this->traversal[$traversalArrayPos]['transform'][0];
            $this->memY += $this->traversal[$traversalArrayPos]['transform'][1];
//            $this->info($i . ': ' . $this->memX . ', ' . $this->memY);
            if (++$steps == $this->traversal[$traversalArrayPos]['steps']) {
                $traversalArrayPos++;
                $steps = 0;
            }
        }
    }

    private function makeTraversalArray() {
        $orderArrayPos = 0;
        $totalSteps = 0;
        for ($i = 1; $i <= $this->test; $i++) {
            $steps = ceil($i/2);
            $totalSteps += $steps;
            $this->traversal[] = ['steps' => $steps, 'direction' => self::ORDER[$orderArrayPos], 'transform' => self::TRANSFORM[self::ORDER[$orderArrayPos]]];
            if (++$orderArrayPos >= count(self::ORDER)) {
                $orderArrayPos = 0;
            }
            if ($totalSteps > $this->test) {
                return;
            }
        }
    }
}
