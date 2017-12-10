<?php

namespace App\Console\Commands;

/**
 * Class Day9Puzzle1
 *
 * @package App\Console\Commands
 */
class Day9Puzzle1 extends AdventCommand
{
    protected $day = 9;
    protected $puzzle = '1';
    protected $inputs = '{test?}';

    protected $default = 'day9input.txt';

    /** @var array */
    public $test = [];
    public $result = 0;

    public $stream = '';
    public $garbageCount = 0;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $length = 100;
        $this->test = $this->getTestInput('test', $this->default);
        $this->info('Input: ' . $this->test);
        $this->prepData();
        $this->info('Stream: ' . print_r(substr($this->stream, 0, $length), true));
        $this->stripCancels();
        $this->info('Stream: ' . print_r(substr($this->stream, 0, $length), true));
        $this->removeGarbage();
        $this->info('Stream: ' . print_r(substr($this->stream, 0, $length), true));
        $this->countGroups();
        $this->info('Puzzle 1 (Group Count): ' . $this->result);
        $this->info('Puzzle 2 (Garbage Count): ' . $this->garbageCount);
        return 0;
    }

    public function prepData()
    {
        $this->stream = file_get_contents(dirname(__FILE__) . '/Data/'.$this->test);
    }

    public function stripCancels()
    {
        $pointer = 0;
        while ($pointer < strlen($this->stream)) {
            if ($this->stream[$pointer] == '!') {
                $this->stream = substr($this->stream, 0, $pointer) . substr($this->stream, $pointer+2);
            } else {
                $pointer++;
            }
        }
    }

    public function removeGarbage()
    {
        preg_match_all('/<([^>]*)>/', $this->stream, $matches);
        usort($matches[1], function ($a,$b) { return strlen($b)-strlen($a); });
        foreach ($matches[1] as $garbage) {
            $this->garbageCount += strlen($garbage);
        };
        array_walk($matches[1], function(&$item, $key) {

            $item = "<{$item}>";
        });
        $matches[1] = array_unique($matches[1]);
        $this->stream = str_replace($matches[1], 'x', $this->stream);
    }

    public function countGroups()
    {
        $openBrackets = 0;
        for ($i = 0; $i < strlen($this->stream); $i++) {
            switch ($this->stream[$i]) {
                case '{':
                    $openBrackets++;
                    break;
                case '}':
                    $this->result += $openBrackets;
                    $openBrackets--;
                    break;
            }
        }
    }
}
