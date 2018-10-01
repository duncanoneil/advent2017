<?php

namespace App\Console\Commands;

/**
 * Class Day16Puzzle2
 *
 * @package App\Console\Commands
 */
class Day16Puzzle2 extends Day16Puzzle1
{
    protected $puzzle = '2';
    public $repeats = 1000;
    public $original = '';
    const MAX = 1000000000;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->prepData();
        $this->original = implode('', $this->line);
        $this->performDance();
        $this->info('Puzzle 2: ' . implode('', $this->line));
        return 0;
    }

    public function performDance()
    {
        $movesToRepeat = $this->performDanceMoves();
        $this->info("Repeat: " . $movesToRepeat);
        $this->repeats = self::MAX % $movesToRepeat;
        $this->info("Target: " . $this->repeats);
        $this->performDanceMoves();
    }

    public function performDanceMoves()
    {
        for ($i = 1; $i <= $this->repeats; $i++) {
            $this->performMoves();
            if ($this->original == implode('', $this->line)) {
                break;
            }
        }
        return $i;
    }
}
