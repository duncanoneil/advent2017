<?php

namespace App\Console\Commands;

/**
 * Class Day3Puzzle2
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
class Day3Puzzle2 extends AdventCommand
{
    protected $day = 3;
    protected $puzzle = '2';
    protected $inputs = '{test?}';

    protected $default = 368078;

    protected $test = '';
    protected $result = null;
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

        $this->buildMemory($this->test);
        $this->makeTraversalArray();
        //$this->info('Traversal Rules: ' . print_r($this->traversal, true));
        $this->traverseMemory($this->test);

        //$this->info('Memory: ' . print_r($this->memory, true));
        $this->info('First Sum over Input: ' . $this->result);
        return 0;
    }

    /**
     * @param int $max
     * @return int
     */
    private function buildMemory($max)
    {
        $max = $this->findSquare($max); //make the memory a square
        if ($max%2 === 0) {
            $max = $this->findSquare($max+1); //Want an odd square
        }
        $this->info('Square: ' . $max);
        $this->memorySize = floor(sqrt($max));
        for ($x = -1 * floor($this->memorySize/2); $x <= floor($this->memorySize/2); $x++) {
            for ($y = -1 * floor($this->memorySize/2); $y <= floor($this->memorySize/2); $y++) {
                $this->addMemorySlot($x, $y);
            }
        }
    }

    private function addMemorySlot($x, $y) {
        //$this->info('Memory Slot: ' . $x . ' ' . $y);
        if (!isset($this->memory[$x])) {
            $this->memory[$x] = [];
        }
        if (!isset($this->memory[$x][$y])) {
            $this->memory[$x][$y] = null;
        }
    }

    private function traverseMemory($to) {
        $this->memX = 0;
        $this->memY = 0;
        $traversalArrayPos = 0;
        $steps = 0;
        //$this->info( '1: ' . $this->memX . ', ' . $this->memY);
        $this->memory[$this->memX][$this->memY] = 1;
        for ($i = 2; $i <= $to; $i++) {
            //$this->info($i . ': ' . print_r($this->traversal[$traversalArrayPos]['transform'], true));
            $this->memX += $this->traversal[$traversalArrayPos]['transform'][0];
            $this->memY += $this->traversal[$traversalArrayPos]['transform'][1];
            //$this->info($i . ': ' . $this->memX . ', ' . $this->memY);
            $this->memory[$this->memX][$this->memY] = $this->sumAdjacentSlots();

            if (++$steps == $this->traversal[$traversalArrayPos]['steps']) {
                $traversalArrayPos++;
                $steps = 0;
            }
            if ($this->result !== null) {
                return 0;
            }
        }
    }

    private function sumAdjacentSlots() {
        $sum = 0;
        for($x = ($this->memX-1); $x <= ($this->memX+1); $x++) {
            for($y = ($this->memY-1); $y <= ($this->memY+1); $y++) {
                if (isset($this->memory[$x][$y])) {
                    //$this->info($x . ', ' . $y. ' value: ' . $this->memory[$x][$y]);
                    $sum += $this->memory[$x][$y];
                }
            }
        }
        //$this->info('sum: ' . $sum);
        if ($sum > $this->test && $this->result === null) {
            $this->result = $sum;
        }
        return $sum;
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
