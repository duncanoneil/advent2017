<?php

namespace App\Console\Commands;

/**
 * Class Day7Puzzle2
 *
 * @package App\Console\Commands
 */
class Day7Puzzle2 extends Day7Puzzle1
{
    protected $puzzle = '2';

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
        $this->checkTowerWeight($this->tower);
        //$this->info('Tower: ' . print_r($this->tower, true));
        $this->info('Result: ' . $this->result);
        return 0;
    }

    public function checkTowerWeight(&$layer)
    {
        $totalWeight = 0;
        $layerWeight = [];
        if (!empty($layer)) {
            foreach ($layer as $key => $item) {
                $layer[$key]['totalWeight'] = $item['weight'];
                if (!empty($item['children'])) {
                    $layer[$key]['totalWeight'] += $this->checkTowerWeight($item['children']);
                }
                $totalWeight += $layer[$key]['totalWeight'];
                $layerWeight[$key] = $layer[$key]['totalWeight'];
            }
            if (max($layerWeight) > min($layerWeight) && empty($this->result)) {
                //$this->result = max($layerWeight) - min($layerWeight);
                $values = array_count_values($layerWeight);
                $mode = array_search(max($values), $values);
                $val = array_search(min($values), $values);
                $this->info('Mode: ' . $mode);
                $this->info('Val: ' . $val);
                $key = array_search($val, $layerWeight);
                $this->result = $layer[$key]['weight'];
                if ($mode > $val) {
                    $this->result += max($layerWeight) - min($layerWeight);
                } else {
                    $this->result -= max($layerWeight) - min($layerWeight);
                }
                $this->info('Key: ' . $key);
            }
        }
        return $totalWeight;
    }
}
