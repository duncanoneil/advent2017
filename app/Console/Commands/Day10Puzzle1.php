<?php

namespace App\Console\Commands;

/**
 * Class Day10Puzzle1
 *
 * @package App\Console\Commands
 */
class Day10Puzzle1 extends AdventCommand
{
    protected $day = 10;
    protected $puzzle = '1';
    protected $inputs = '{length?} {file?}';

    protected $file = 'day10input.txt';

    public $result = '';

    public $length = 255;
    public $data = [];
    public $lengths = [];
    public $pointer = 0;
    public $skip = 0;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->prepData();
        $this->processData();
        $this->info('Puzzle 1: ' . ($this->data[0] * $this->data[1]));
        return 0;
    }

    public function prepData()
    {
        $this->length = $this->getTestInput('length', $this->length);
        $this->file = $this->getTestInput('file', $this->file);
        $this->lengths = explode(',', file_get_contents(dirname(__FILE__) . '/Data/'.$this->file));
        for ($i = 0; $i <= $this->length; $i++) {
            $this->data[] = $i;
        }
    }

    public function processData()
    {
        foreach ($this->lengths as $length) {
            //var_dump($length);
            if ($length > count($this->data)) { continue; }
            if ($length == 1) { $this->movePointer($length); continue; }
            $this->flipSubSection($length);
            $this->movePointer($length);
        }
    }

    public function movePointer($length)
    {
        $this->pointer = $this->pointer($length + $this->skip);
        $this->skip++;
        //$this->info('State: ' . implode(', ',$this->data));
        //$this->info('Pointer: ' . $this->pointer .' = ' . $this->data[$this->pointer]);
        //$this->info('Skip: ' . $this->skip);
    }

    public function flipSubSection($length)
    {
        for ($i = 0; $i < ceil($length/2); $i++) {
            //print $this->pointer($i) . ' -- '. $this->pointer($length - $i -1) . PHP_EOL;
            if (($length - $i -1) == $i) { continue; }
            $tempData = $this->data[$this->pointer($i)];
            $this->data[$this->pointer($i)] = $this->data[$this->pointer($length - $i -1)];
            $this->data[$this->pointer($length - $i -1)] = $tempData;
        }
    }

    public function pointer($increment)
    {
        //var_dump(($this->pointer + $increment), count($this->data));
        if (($this->pointer + $increment) >= count($this->data)) {
            return ($this->pointer($increment - count($this->data)));
        }
        return ($this->pointer + $increment);
    }
}
