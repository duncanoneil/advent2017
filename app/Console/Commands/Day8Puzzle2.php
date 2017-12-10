<?php

namespace App\Console\Commands;

/**
 * Class Day8Puzzle2
 *
 * @package App\Console\Commands
 */
class Day8Puzzle2 extends Day8Puzzle1
{
    protected $puzzle = '2';
    public $max = 0;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->test = $this->getTestInput('test', $this->default);
        $this->prepData();
        $this->processRegister();
        $this->info('Register: ' . print_r($this->register, true));
        $this->info('Result: ' . $this->max);
        return 0;
    }

    public function checkRegisterValue($ref)
    {
        if (!isset($this->register[$ref])) {
            $this->register[$ref] = 0;
        } else {
            $this->max = max([$this->register[$ref], $this->max]);
        }
        return $ref;
    }
}
