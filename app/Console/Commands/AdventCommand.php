<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

abstract class AdventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'advent:';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advent of Code: ';

    /**
     * The day
     *
     * @var int
     */
    protected $day = 0;

    /**
     * The puzzle
     *
     * @var string
     */
    protected $puzzle = 0;

    /**
     * Inputs
     *
     * @var string
     */
    protected $inputs = '';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->signature .= 'd'.$this->day.'p'.$this->puzzle;
        if (!empty($this->inputs)) {
            $this->signature .= ' ' . $this->inputs;
        }
        $this->description .= 'Day '.$this->day.' Puzzle '.$this->puzzle;
        parent::__construct();
    }

    public function getTestInput($key, $default) {
        $input = ($this->argument($key) !== null) ? $this->argument($key) : $default;
        $this->line(ucfirst($key) . ': ' . print_r($input, true));
        return $input;
    }
}
