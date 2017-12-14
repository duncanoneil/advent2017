<?php

namespace App\Console\Commands;

/**
 * Class Day13Puzzle2
 *
 * @package App\Console\Commands
 */
class Day13Puzzle2 extends Day13Puzzle1
{
    protected $puzzle = '2';
    public $delay = -1;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->prepData();
        $this->crossFirewall();
        $this->info('Puzzle 2: ' . $this->delay);
        $this->info(str_repeat('-', 10));
        return 0;
    }

    /**
     *
     */
    public function crossFirewall()
    {
        do {
            $this->caught = false;
            $this->severity = 0;
            $this->delay++;
            for ($i = 0; $i <= $this->width; $i++) {
                $this->severity += $this->checkScanner($i, ($i + $this->delay));
            }

            //$this->info('Delay: ' . $this->delay . ' / Severity: ' . $this->severity);
            //$this->info(str_repeat('-', 5));
            //$this->error('Caught?' . ($this->caught) ? 'yes' : 'no');
        } while ($this->caught === true);
    }
}
