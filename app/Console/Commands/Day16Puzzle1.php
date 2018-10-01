<?php

namespace App\Console\Commands;

/**
 * Class Day16Puzzle1
 *
 * @package App\Console\Commands
 */
class Day16Puzzle1 extends AdventCommand
{
    protected $day = 16;
    protected $puzzle = '1';
    protected $inputs = '{file?} {length?}';
    protected $length = 16;
    protected $file = 'day16input.txt';
    public $moves = [];
    public $line = [];
    public $tmpVal = '';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->prepData();
        $this->performMoves();
        $this->info('Puzzle 1: ' . implode('', $this->line));
        return 0;
    }

    public function prepData()
    {
        $this->length = $this->getTestInput('length', $this->length);
        $this->file = $this->getTestInput('file', $this->file);
        $this->moves = explode(',', trim(file_get_contents(dirname(__FILE__) . '/Data/'.$this->file)));
        for ($i = 0; $i < $this->length; $i++) {
            $this->line[] = chr($i+97);
        }
    }

    public function performMoves()
    {
        foreach ($this->moves as $key => $move) {
            preg_match('/([s|x|p]){1}([a-z|0-9]{1,2})[^,]?([a-z|0-9]*)/', $move, $matches);
            switch($matches[1]) {
                case 's':
                    $this->spin($matches[2]);
                    break;
                case 'x':
                    $this->exchange($matches[2], $matches[3]);
                    break;
                case 'p':
                    $this->partner($matches[2], $matches[3]);
                    break;
            }
        }
    }

    public function spin($x)
    {
        $this->line = array_merge(array_slice($this->line, ($x * -1)), array_slice($this->line, 0, ($x * -1)));
        // Spin, written sX, makes X programs move from the end to the front, but maintain their order otherwise. (For example, s3 on abcde produces cdeab).
    }

    public function exchange($a, $b)
    {
        $this->tmpVal = $this->line[$a];
        $this->line[$a] = $this->line[$b];
        $this->line[$b] = $this->tmpVal;
        // Exchange, written xA/B, makes the programs at positions A and B swap places.
    }

    public function partner($a, $b)
    {
        $this->exchange(array_search($a, $this->line), array_search($b, $this->line));
        // Partner, written pA/B, makes the programs named A and B swap places.
    }
}
