<?php

namespace App\Console\Commands;

/**
 * Class Day5Puzzle1
 *
 * @package App\Console\Commands
 */
class Day5Puzzle1 extends AdventCommand
{
    protected $day = 5;
    protected $puzzle = '1';
    protected $inputs = '{test?}';

    protected $default = '';

    protected $test = '';
    protected $move = 0;
    protected $pointer = 0;
    protected $totalMoves = 0;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->default = file_get_contents(dirname(__FILE__) . '/Data/day5input.txt');
        $this->default = explode(PHP_EOL, $this->default);
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $memory_limit = ini_get('memory_limit');
//        $this->info('Memory: ' . $this->get_memory_usage($memory_limit));
//        die();

        $this->test = $this->getTestInput('test', $this->default);
        $this->prepData();

        while (false !== $this->evaluateMove()) {
            $this->performMove();
        }

        $this->info('Total Moves: ' . $this->totalMoves);
        return 0;
    }

    public function prepData()
    {
        if (!is_array($this->test)) {
            $this->test = explode(',', $this->test);
        }
     }

    /**
     * @return int|bool
     */
    private function evaluateMove()
    {
        $this->move = (isset($this->test[$this->pointer])) ? $this->test[$this->pointer] : false;
        return $this->move;
    }

    public function performMove()
    {
        $this->totalMoves++;
        $this->test[$this->pointer]++;
        $this->pointer += $this->move;
    }
}
