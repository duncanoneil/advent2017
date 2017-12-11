<?php

namespace App\Console\Commands;

/**
 * Class Day10Puzzle2
 *
 * @package App\Console\Commands
 */
class Day10Puzzle2 extends Day10Puzzle1
{
    protected $puzzle = '2';

    public $xor = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->prepData();
        $this->info('Lengths: ' . implode(', ', $this->lengths));
        for ($i = 1; $i <= 64; $i++) {
            $this->processData();
        }
        $this->xorData();
        $this->hexResult();
        $this->info('Puzzle 2: ' . $this->result);
        return 0;
    }

    public function prepData()
    {
        $this->length = $this->getTestInput('length', $this->length);
        $this->file = $this->getTestInput('file', $this->file);
        if (file_exists(dirname(__FILE__) . '/Data/'.$this->file)) {
            $this->lengths = str_split(trim(file_get_contents(dirname(__FILE__) . '/Data/'.$this->file)));
        } else {
            $this->lengths = str_split(trim($this->file));
        }
        array_walk($this->lengths, function (&$item, $key) {
            $item = ord($item);
        });
        $this->lengths = array_merge($this->lengths, [17, 31, 73, 47, 23]);
        for ($i = 0; $i <= $this->length; $i++) {
            $this->data[] = $i;
        }
    }

    public function xorData()
    {
        for ($i = 0; $i < 16; $i++) {
            $offset = 16 * $i;
            $calc = $this->data[$offset];
            for ($j = 1; $j < 16; $j++) {
                $calc ^= $this->data[$offset+$j];
            }
            $this->xor[$i] = $calc;
        }
    }

    public function hexResult()
    {
        foreach ($this->xor as $int) {
            $this->result .= str_pad(dechex($int), 2, '0', STR_PAD_LEFT);
        }
    }
}
