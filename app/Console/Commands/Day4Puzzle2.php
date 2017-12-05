<?php

namespace App\Console\Commands;

/**
 * Class Day4Puzzle2
 *
 * @package App\Console\Commands
 */
class Day4Puzzle2 extends Day4Puzzle1
{
    protected $puzzle = '2';

    public function checkPhrase($phrase, $delim = self::WORDBREAK) {
        $words = explode($delim, $phrase);
        array_walk($words, function(&$word, $key) {
            $letters = str_split($word);
            sort($letters);
            $word = implode('', $letters);
        });
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
