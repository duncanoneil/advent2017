<?php

namespace App\Console\Commands;

/**
 * Class Day14Puzzle1
 *
 * @package App\Console\Commands
 */
class Day14Puzzle1 extends AdventCommand
{
    protected $day = 14;
    protected $puzzle = '1';
    protected $inputs = '{input?}';
    public $input = 'hwlqcszp';
    public $length = 255;
    public $data = [];
    public $initialData = [];
    public $keys = [];
    public $hashes = [];
    public $pointer = 0;
    public $skip = 0;
    public $result = 0;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->input = $this->getTestInput('input', $this->input);
        $this->prepInput();
        //$this->info('Keys: ' . print_r($this->keys));
        $this->calcHashes();
        //$this->info('Hashes: ' . PHP_EOL . implode(PHP_EOL, $this->hashes));
        $this->readHashes();
        $this->info('Puzzle 1: ' . $this->result);
        return 0;
    }

    public function readHashes()
    {
        //$this->error('GRID');
        foreach ($this->hashes as $hash) {
            $hash = str_split($hash);
            array_walk($hash, function (&$item, $key) {
                $item = base_convert($item, 16, 2);
                $item = str_pad($item, 4, '0', STR_PAD_LEFT);
            });
            $hash = implode('',$hash);
            //$this->info($hash);
            $this->result += substr_count($hash, '1');
        }
    }

    public function prepInput()
    {
        $this->input = trim($this->input);
        for ($i = 0; $i <= 127; $i++) {
            $key = str_split($this->input . '-' . $i);
            array_walk($key, function (&$item, $key) {
                $item = ord($item);
            });
            $this->keys[] = array_merge($key, [17, 31, 73, 47, 23]);
        }
        for ($i = 0; $i <= $this->length; $i++) {
            $this->initialData[] = $i;
        }
    }

    public function calcHashes()
    {
        foreach ($this->keys as $key) {
            $this->hashes[] = $this->knotHash($key);
        }
    }

    public function knotHash($key)
    {
        $this->pointer = $this->skip = 0;
        $this->data = $this->initialData;
        for ($i = 1; $i <= 64; $i++) {
            $this->processData($key);
        }
        return $this->hexResult($this->xorData($this->data));
    }

    public function processData($key)
    {
        foreach ($key as $length) {
            //var_dump($length);
            if ($length > count($this->data)) { continue; }
            if ($length == 1) { $this->movePointer($length); continue; }
            $this->flipSubSection($length);
            $this->movePointer($length);
        }
    }

    public function movePointer($length)
    {
        $this->pointer = $this->pointer($length + $this->skip);
        $this->skip++;
    }

    public function flipSubSection($length)
    {
        for ($i = 0; $i < ceil($length/2); $i++) {
            //print $this->pointer($i) . ' -- '. $this->pointer($length - $i -1) . PHP_EOL;
            if (($length - $i -1) == $i) { continue; }
            $tempData = $this->data[$this->pointer($i)];
            $this->data[$this->pointer($i)] = $this->data[$this->pointer($length - $i -1)];
            $this->data[$this->pointer($length - $i -1)] = $tempData;
        }
    }

    public function pointer($increment)
    {
        //var_dump(($this->pointer + $increment), count($this->data));
        if (($this->pointer + $increment) >= count($this->data)) {
            return ($this->pointer($increment - count($this->data)));
        }
        return ($this->pointer + $increment);
    }

    public function xorData($data)
    {
        $xor = [];
        for ($i = 0; $i < 16; $i++) {
            $offset = 16 * $i;
            $calc = $data[$offset];
            for ($j = 1; $j < 16; $j++) {
                $calc ^= $data[$offset+$j];
            }
            $xor[$i] = $calc;
        }
        return $xor;
    }

    public function hexResult($xor)
    {
        $result = '';
        foreach ($xor as $int) {
            $result .= str_pad(dechex($int), 2, '0', STR_PAD_LEFT);
        }
        return $result;
    }
}
