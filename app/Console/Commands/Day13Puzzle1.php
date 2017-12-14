<?php

namespace App\Console\Commands;

/**
 * Class Day13Puzzle1
 *
 * @package App\Console\Commands
 */
class Day13Puzzle1 extends AdventCommand
{
    protected $day = 13;
    protected $puzzle = '1';
    protected $inputs = '{file?}';

    protected $file = 'day13input.txt';

    public $result = '';
    public $layers = [];
    public $width = [];
    public $severity = 0;
    public $caught = false;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->prepData();
        $this->crossFirewall();
        $this->info('Puzzle 1: ' . $this->severity);
        $this->info(str_repeat('-', 10));
        return 0;
    }

    public function prepData()
    {
        $this->file = $this->getTestInput('file', $this->file);
        if (file_exists(dirname(__FILE__) . '/Data/'.$this->file)) {
            $this->makeFirewall(file_get_contents(dirname(__FILE__) . '/Data/'.$this->file));
        } else {
            $this->makeFirewall($this->file);
        }
    }

    /**
     * @param $input
     */
    public function makeFirewall($input)
    {
        $input = explode(PHP_EOL, $input);
        foreach ($input as $layer) {
            $layer = explode(': ', $layer);
            $this->layers[$layer[0]] = $layer[1];
        }
        array_walk_recursive($this->layers, function(&$item, $key) {
            $item = trim($item);
        });
        end($this->layers);
        $this->width = key($this->layers);
    }

    /**
     *
     */
    public function crossFirewall()
    {
        for($i = 0; $i <= $this->width; $i++) {
            $this->severity += $this->checkScanner($i, $i);
        }
    }

    /**
     * @param $layer
     * @param $time
     * @return int
     */
    public function checkScanner($layer, $time)
    {
        if (!isset($this->layers[$layer])) {
            return 0;
        }
        $repeat = 2 * ($this->layers[$layer] - 1);
        //$this->info('Time: ' . $time . 'Layer: ' . $layer . ' / Depth: ' . $this->layers[$layer] . ' / Repeat: ' . $repeat . ' / Mod: ' . ($time % $repeat));
        if ($time % $repeat == 0) {
            $this->caught = true;
            //$this->error('Caught!');
            return $layer * $this->layers[$layer];
        }
        return 0;
    }

}
