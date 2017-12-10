<?php

namespace App\Console\Commands;

/**
 * Class Day7Puzzle1
 *
 * @package App\Console\Commands
 */
class Day7Puzzle1 extends AdventCommand
{
    protected $day = 7;
    protected $puzzle = '1';
    protected $inputs = '{test?}';

    protected $default = 'day7input.txt';

    /** @var array */
    public $test = [];
    public $result = 0;

    public $data = [];
    public $tower = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->test = $this->getTestInput('test', $this->default);
        $this->info('Input: ' . $this->test);
        $this->prepData();
        $this->buildTower();
        $this->assembleTower();
//        $this->info('Tower: ' . print_r($this->tower, true));
        $this->info('Result: ' . print_r(array_keys($this->tower), true));
        return 0;
    }

    public function prepData()
    {
        $file = file_get_contents(dirname(__FILE__) . '/Data/'.$this->test);
//        $this->line('File: ' . PHP_EOL . print_r($file, true));
        $this->data = explode(PHP_EOL, $file);
    }

    public function buildTower()
    {
        foreach($this->data as $layer) {
            preg_match_all('/([\w]+) \(([\d]+)\)( -> ([\w, ]*))?/', $layer, $matches);
            $children = (!empty($matches[4][0])) ? explode(',',$matches[4][0]) : null;
            $this->tower[$matches[1][0]] = ['weight' => $matches[2][0], 'children' => $children];
        }
    }

    public function assembleTower()
    {
        while (count($this->tower) > 1) {
            foreach ($this->tower as $key => $layer) {
                if (!isset($this->tower[$key])) continue;
                $this->tower[$key]['children'] = $this->checkLayer($layer);
            }
            //$this->info('Tower: ' . print_r($this->tower, true));
        }
    }

    public function checkLayer($layer) {
        if ($layer['children'] !== null) {
            foreach ($layer['children'] as $cKey => $child) {
                if (is_array($child)) {
                    $layer['children'][$cKey]['children'] = $this->checkLayer($child);
                } else {
                    $child = trim($child);
                    $layer['children'][$child] = $this->tower[$child];
                    unset($layer['children'][$cKey]);
                    unset($this->tower[$child]);
                }
            }
        }
        return $layer['children'];
    }
}
