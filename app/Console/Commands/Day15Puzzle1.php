<?php

namespace App\Console\Commands;

/**
 * Class Day15Puzzle1
 *
 * @package App\Console\Commands
 */
class Day15Puzzle1 extends AdventCommand
{
    protected $day = 15;
    protected $puzzle = '1';
    protected $inputs = '{repeat?}';
    public $repeat = 40000000;
    public $generator = ['A' => 699, 'B' => 124];
    //public $generator = ['A' => 65, 'B' => 8921]; //test

    public $factor = ['A' => 16807, 'B' => 48271];
    public $result = 0;

    const DIV = 2147483647;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->repeat = $this->getTestInput('repeat', $this->repeat);
        $this->runLoops();
        $this->info('Puzzle 1: ' . $this->result);
        return 0;
    }

    public function runLoops()
    {
        for ($i = 1; $i <= $this->repeat; $i++) {
//            $this->info('State: ' . $this->generator['A'] . ' & ' . $this->generator['B']);
            $this->judge($this->generate('A'), $this->generate('B'));
        }
    }

    public function judge($a, $b)
    {
//        $this->info('Comparing: ' . $a . ' & ' . $b);
        $a = str_pad(base_convert($a, 10, 2), 32, 0, STR_PAD_LEFT);
        $b = str_pad(base_convert($b, 10, 2), 32, 0, STR_PAD_LEFT);
//        $this->info('Comparing: ' . $a . ' & ' . $b);
        if (substr($a, -16) == substr($b, -16)) {
            $this->result++;
        }
        //compares the lowest 16 bits of both values, and
        // keeps track of the number of times those parts of the values match.
    }

    public function generate($generator)
    {
        $this->generator[$generator] = ($this->generator[$generator] * $this->factor[$generator]) % self::DIV;
        return $this->generator[$generator];
        //The generators both work on the same principle.
        // To create its next value, a generator will take the previous value it produced,
        // multiply it by a factor (generator A uses 16807; generator B uses 48271), and
        // then keep the remainder of dividing that resulting product by 2147483647.
        // That final remainder is the value it produces next.
    }
}
