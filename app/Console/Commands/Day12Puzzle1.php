<?php

namespace App\Console\Commands;

/**
 * Class Day12Puzzle1
 *
 * @package App\Console\Commands
 */
class Day12Puzzle1 extends AdventCommand
{
    protected $day = 12;
    protected $puzzle = '1';
    protected $inputs = '{file?}';

    protected $file = 'day12input.txt';

    public $result = '';
    public $pipes = [];
    public $seen = [];


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->prepData();
        //$this->info(print_r($this->pipes, true));
        $this->checkPipe(0);
        $this->info('Puzzle 1: ' . count($this->seen));
        $this->info(str_repeat('-', 10));
        return 0;
    }

    public function prepData()
    {
        $this->file = $this->getTestInput('file', $this->file);
        if (file_exists(dirname(__FILE__) . '/Data/'.$this->file)) {
            $this->makePipes(file_get_contents(dirname(__FILE__) . '/Data/'.$this->file));
        } else {
            $this->makePipes($this->file);
        }
    }

    public function makePipes($input)
    {
        $input = explode(PHP_EOL, $input);
        foreach ($input as $pipe) {
            $pipeParts = explode(' <-> ', $pipe);
            if (!empty($pipeParts[1])) {
                $this->pipes[$pipeParts[0]] = explode(',', $pipeParts[1]);
            } else {
                $this->info($pipeParts[0] . ' has no connections');
                $this->pipes[$pipeParts[0]] = [];
            }
        }
        array_walk_recursive($this->pipes, function(&$item, $key) {
            $item = trim($item);
        });
    }

    public function checkPipe($input)
    {
        if (in_array($input, $this->seen)) {
            return;
        }
        $this->seen[] = $input;
        foreach ($this->pipes[$input] as $pipe) {
            $this->checkPipe($pipe);
        }
    }

}
