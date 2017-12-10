<?php

namespace App\Console\Commands;

/**
 * Class Day6Puzzle1
 *
 * @package App\Console\Commands
 */
class Day6Puzzle1 extends AdventCommand
{
    protected $day = 6;
    protected $puzzle = '1';
    protected $inputs = '{test?}';

    protected $default = [14, 0, 15, 12, 11, 11, 3, 5, 1, 6, 8, 4, 9, 1, 8, 4];
    //protected $default = [0, 2, 7, 0];

    /** @var array */
    protected $test = [];
    protected $states = [];
    protected $result = 0;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->test = $this->getTestInput('test', $this->default);
        while ($this->checkStates()) {
            $this->redistributeData();
        }
        $this->info('Result: ' . $this->result);
        return 0;
    }

    public function checkStates()
    {
        if (in_array($this->test, $this->states)) {
            return false;
        } else {
            $this->states[] = $this->test;
            return true;
        }
    }

    public function redistributeData()
    {
        $this->states[] = $this->test;
        $this->result++;
        $data = max($this->test);
        $key = array_search($data, $this->test);
        $this->test[$key] = 0;
        for ($i = 1; $i <= $data; $i++) {
            if (!isset($this->test[++$key])) {
                $key = 0;
            }
            $this->test[$key]++;
        }
//        $this->info('State after '.$this->result.': ' . print_r($this->test, true));
    }
}
