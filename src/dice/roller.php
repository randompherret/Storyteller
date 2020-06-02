<?php

namespace src\Dice;


class roller {
    public function roll(string $dice): int {
        if (!preg_match('/^(100|[0-9]{1,2})?d((?:[0-9]{0,3}|%))?([+|\-][0-9]{0,3})?/', $dice, $matches)) {
            return 0;
        }
        $matches = array_pad($matches, 3, 6);
        $matches = array_pad($matches, 4, 0);
        $results = 0;
        $i = 0;
        while ($i < $matches[1]) {
            $results += $this->toss($matches[2]);
            $i++;
        }
        $results += $matches[3];
        return $results;
    }
    private function toss(int $sides): int {
        return rand(1,$sides);
    }

}