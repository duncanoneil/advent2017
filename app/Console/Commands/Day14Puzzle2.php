<?php

namespace App\Console\Commands;

/**
 * Class Day14Puzzle2
 *
 * @package App\Console\Commands
 */
class Day14Puzzle2 extends Day14Puzzle1
{
    protected $puzzle = '2';
    public $regions = 0;
    public $grid = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->input = $this->getTestInput('input', $this->input);
        $this->prepInput();
        $this->info('Input done');
        $this->calcHashes();
        $this->info('Hashes done');
        $this->readHashes();
        $this->info('Grid done');
        $this->parseGrid();
        $this->info('Puzzle 2: ' . $this->regions);
        return 0;
    }

    public function parseGrid()
    {
        foreach ($this->grid as $rowKey => $row) {
            foreach ($row as $colKey => $cell) {
                if ($this->grid[$rowKey][$colKey] === 'X') {
                    $this->regions++;
                    $this->searchFrom($rowKey, $colKey);
                }
            }
        }
    }

    public function searchFrom($x, $y)
    {
        $this->grid[$x][$y] = 0;
        if (isset($this->grid[($x - 1)][($y)]) && $this->grid[($x - 1)][($y)] === 'X') {
            $this->searchFrom(($x - 1), ($y));
        }
        if (isset($this->grid[($x + 1)][($y)]) && $this->grid[($x + 1)][($y)] === 'X') {
            $this->searchFrom(($x + 1), ($y));
        }
        if (isset($this->grid[($x)][($y - 1)]) && $this->grid[($x)][($y - 1)] === 'X') {
            $this->searchFrom(($x), ($y - 1));
        }
        if (isset($this->grid[($x)][($y + 1)]) && $this->grid[($x)][($y + 1)] === 'X') {
            $this->searchFrom(($x), ($y+1));
        }
    }

    public function readHashes()
    {
        foreach ($this->hashes as $hash) {
            $hash = str_split($hash);
            array_walk($hash, function (&$item, $key) {
                $item = base_convert($item, 16, 2);
                $item = str_pad($item, 4, '0', STR_PAD_LEFT);
            });
            $hash = implode('',$hash);
            $this->result += substr_count($hash, '1');
            $hash = str_replace('1','X', $hash);
            $this->grid[] = str_split($hash);
        }
    }
}
