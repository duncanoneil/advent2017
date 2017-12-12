<?php

namespace App\Console\Commands;

/**
 * Class Day11Puzzle1
 *
 * @package App\Console\Commands
 */
class Day11Puzzle1 extends AdventCommand
{
    protected $day = 11;
    protected $puzzle = '1';
    protected $inputs = '{file?}';

    protected $file = 'day11input.txt';

    public $result = '';

    public $steps = [];
    public $pointer = 0;
    public $transform = [
        'n' => ['s' => false, 'se' => 'ne', 'sw' => 'nw'],
        'ne' => ['nw' => 'n', 'sw' => false, 's' => 'se'],
        'se' => ['n' => 'ne', 'nw' => false, 'sw' => 's'],
        's' => ['n' => false, 'nw' => 'sw', 'ne' => 'se'],
        'sw' => ['n' => 'nw', 'ne' => false, 'se' => 's'],
        'nw' => ['ne' => 'n', 'se' => false, 's' => 'sw'],
    ];

    public $removedSteps;
    public $step;
    public $nextStep;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->prepData();
        $this->processData();
        $this->info('Puzzle 1: ' . count($this->steps));
        $this->info('Steps: ' . implode(', ', $this->steps));
        $this->info(str_repeat('-', 10));
        return 0;
    }

    public function prepData()
    {
        $this->file = $this->getTestInput('file', $this->file);
        if (file_exists(dirname(__FILE__) . '/Data/'.$this->file)) {
            $this->steps = explode(',', trim(file_get_contents(dirname(__FILE__) . '/Data/'.$this->file)));
        } else {
            $this->steps = explode(',', trim($this->file));
        }
    }

    public function processData()
    {
        $this->removedSteps = 0;
        while ($this->pointer < (count($this->steps) - 1)) {
            //            $this->info(str_repeat('-', 5));
            $this->pointer += $this->checkStep(1);
            //            $this->line('Steps: ' . implode(', ', $this->steps));
        }
    }

    public function checkStep($offset)
    {
        if (!array_key_exists(($this->pointer + $offset), $this->steps)) {
            return 1;
        }
        $this->step = $this->steps[$this->pointer];
        $this->nextStep = $this->steps[($this->pointer + $offset)];
//        $this->info($this->step . ' vs ' . $this->nextStep);
        if (array_key_exists($this->nextStep, $this->transform[$this->step])) {
            $transform = $this->transform[$this->step][$this->nextStep];
            //print 'T: ';
//                var_dump($transform);
            unset($this->steps[$this->pointer]);
            $this->removedSteps++;
            if ($transform === false) {
                unset($this->steps[($this->pointer + $offset)]);
                $this->removedSteps++;
            } else {
                //make next the transform step (which the pointer is now at)
                $this->steps[$this->pointer + $offset] = $transform;
            }
            $this->steps = array_values($this->steps);
        } else {
            //steps don't cancel, check next
            return $this->checkStep($offset+1);
        }
        return 0;//($offset == 1) ? 0 : 1;
    }

}
