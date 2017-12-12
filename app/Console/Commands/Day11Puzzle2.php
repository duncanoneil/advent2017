<?php

namespace App\Console\Commands;

/**
 * Class Day11Puzzle2
 *
 * @package App\Console\Commands
 */
class Day11Puzzle2 extends Day11Puzzle1
{
    protected $puzzle = '2';

    public $originalSteps = [];
    public $distances = [];
    public $distance = 0;
    public $furthestDistance = 0;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->prepData();
        $this->steps[] = $this->originalSteps[0];
        for ($i = 1; $i < count($this->originalSteps); $i++) {
            $this->steps = array_merge($this->steps, [$this->originalSteps[$i]]);
            $this->info('Steps: ' . implode(', ', $this->steps));
            $this->processData();
            $this->distances[$i] = count($this->steps);
            $this->info('Steps: ' . implode(', ', $this->steps));
            //if ($i > 30) { die(); }
        }
        $this->info('Puzzle 2: ' . max($this->distances));
        $this->info(str_repeat('-', 10));
        return 0;
    }

    public function prepData()
    {
        $this->file = $this->getTestInput('file', $this->file);
        if (file_exists(dirname(__FILE__) . '/Data/'.$this->file)) {
            $this->originalSteps = explode(',', trim(file_get_contents(dirname(__FILE__) . '/Data/'.$this->file)));
        } else {
            $this->originalSteps = explode(',', trim($this->file));
        }
    }

    public function processData()
    {
        $this->pointer = count($this->steps) - 1;
        $this->checkStep($this->pointer  * -1);
    }

    public function checkDistance($step)
    {
        if ($step > 100) die();
        if (!array_key_exists(($step + 1), $this->steps)) {
            return false;
        }
        $this->step = $this->steps[$step];
        $this->nextStep = $this->steps[($step + 1)];
        if (array_key_exists($this->nextStep, $this->transform[$this->step])) {
            $transform = $this->transform[$this->step][$this->nextStep];
            if ($transform === false) {
                $this->distance--;
            }
        } else {
            $this->distance++;
            $this->furthestDistance = max($this->distance, $this->furthestDistance);
        }
        $this->info($this->step . ' -> ' . $this->nextStep . ' ~~ ' . $this->distance);
        return true;
    }

}
