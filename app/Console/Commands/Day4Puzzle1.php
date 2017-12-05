<?php

namespace App\Console\Commands;

/**
 * Class Day4Puzzle1
 *
 * @package App\Console\Commands
 */
class Day4Puzzle1 extends AdventCommand
{
    protected $day = 4;
    protected $puzzle = '1';
    protected $inputs = '{test?}';

    protected $default = '';

    protected $test = '';
    protected $totalValid = 0;
    protected $totalChecked = 0;

    const LINEBREAK = PHP_EOL;
    const WORDBREAK = ' ';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        $this->default = file_get_contents(dirname(__FILE__) . '/Data/day4input.txt');
        parent::__construct();
    }

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
        $this->checkPhrases();

        $this->info('Total Valid Passphrases: ' . $this->totalValid);
        return 0;
    }

    public function prepData($delim = self::LINEBREAK)
    {
        if (empty($this->test)) {
            throw new Exception('No Content to check');
        }
        $this->test = explode($delim, $this->test);
    }

    /**
     * @return int
     */
    private function checkPhrases()
    {
        foreach ($this->test as $phrase) {
            ($this->checkPhrase($phrase)) ? $this->totalValid++ : 0 ;
            $this->totalChecked++;
        }
    }

    public function checkPhrase($phrase, $delim = self::WORDBREAK) {
        $words = explode($delim, $phrase);
        foreach ($words as $key=>$word) {
            foreach ($words as $checkKey=>$checkWord) {
                if ($key == $checkKey) {
                    continue;
                }
                if ($word == $checkWord) {
                    return false;
                }
            }
        }
        return true;
    }
}
