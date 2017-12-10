<?php

namespace App\Console\Commands;

/**
 * Class Day8Puzzle1
 *
 * @package App\Console\Commands
 */
class Day8Puzzle1 extends AdventCommand
{
    protected $day = 8;
    protected $puzzle = '1';
    protected $inputs = '{test?}';

    protected $default = 'day8input.txt';

    /** @var array */
    public $test = [];
    public $result = 0;

    public $instructions = [];
    public $register = [];
    public $pointer = '';
    public $updater = '';

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
        $this->info('Result: ' . max($this->register));
        return 0;
    }

    public function prepData()
    {
        $file = file_get_contents(dirname(__FILE__) . '/Data/'.$this->test);
//        $this->info('File: ' . print_r($file, true));
        $this->instructions = explode(PHP_EOL, $file);
    }

    public function processRegister()
    {
        foreach($this->instructions as $instruction) {
            if (empty($instruction)) {
                continue;
            }
//            $this->info('Instruction: ' . $instruction);
            preg_match_all('/([\w]+) ([\w]+) ([-\d]+) if ([\w]+) ([\D]+) ([-\d]+)/', $instruction, $matches);

            $this->updater = $this->checkRegisterValue($matches[1][0]);
            $this->pointer = $this->checkRegisterValue($matches[4][0]);
            if ($this->checkInstruction($matches[5][0], $matches[6][0])) {
                $check = $this->register[$this->pointer] . ' ' . $matches[5][0] . ' ' . $matches[6][0];
//                $this->info('Check: ' . $check);
                $this->updateRegister($check, $matches[2][0], $matches[3][0]);
            }
        }
    }

    public function checkRegisterValue($ref)
    {
        if (!isset($this->register[$ref])) {
            $this->register[$ref] = 0;
        }
        return $ref;
    }

    public function checkInstruction($operator, $value)
    {
        switch ($operator) {
            case '>':
                return ($this->register[$this->pointer] > $value);
                break;
            case '<':
                return ($this->register[$this->pointer] < $value);
                break;
            case '>=':
                return ($this->register[$this->pointer] >= $value);
                break;
            case '<=':
                return ($this->register[$this->pointer] <= $value);
                break;
            case '==':
                return ($this->register[$this->pointer] == $value);
                break;
            case '!=':
                return ($this->register[$this->pointer] != $value);
                break;
        }
        return false;
    }

    public function updateRegister($check, $operation, $modifier)
    {
//        $this->info('Before: ' . print_r($this->register[$this->updater], true));

        switch ($operation) {
            case 'inc':
                $this->register[$this->updater] += $modifier;
                break;
            case 'dec':
                $this->register[$this->updater] -= $modifier;
                break;

        }

//        $this->info('After: ' . print_r($this->register[$this->updater], true));
    }
}
