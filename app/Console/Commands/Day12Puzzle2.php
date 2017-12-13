<?php

namespace App\Console\Commands;

/**
 * Class Day12Puzzle2
 *
 * @package App\Console\Commands
 */
class Day12Puzzle2 extends Day12Puzzle1
{
    protected $puzzle = '2';
    public $groups = 0;

    public function handle()
    {
        $this->prepData();
        //$this->info(print_r($this->pipes, true));
        $this->checkPipe(0);
        $this->groups++;
        $this->findGroups();
        $this->info('Puzzle 2: ' . $this->groups);
        $this->info(str_repeat('-', 10));
        return 0;
    }
    public function findGroups() {
        foreach ($this->pipes as $pipe => $conns) {
            if (in_array($pipe, $this->seen)) {
                continue;
            }
            $this->checkPipe($pipe);
            $this->groups++;
        }
    }
}
