<?php

require_once 'ff_basic.php';

class book_wofm extends book_ff_basic {
    public function getId() {
        return 'wofm';
    }


    public function rollCharacter($name = '?', $gender = '?', $emoji = '?', $race = '?', $adjective = '?', $seed = '?') {
        $p = parent::rollCharacter($name, $gender, $emoji, $race, $adjective, $seed);
        // Starting Equipment
        $p['stuff'] = array('Sword (+0)', 'Leather Armor', 'Lantern');
        $p['prov'] = 3;
        // Random Potion
        // The book rules actually give you a choice, but this is a bit more fun
        $p['creationdice'][] = dice();
        switch ($p['creationdice'][4]) {
        case 1: case 2:
            $p['stuff'][] = 'Potion of Skill';
            break;
        case 3: case 4:
            $p['stuff'][] = 'Potion of Strength';
            break;
        case 5: case 6:
            $p['stuff'][] = 'Potion of Luck';
            // If the potion of luck is chosen, the player get 1 bonus luck
            $p['luck']++;
            $p['max']['luck']++;
            break;
        }
        return $p;
    }


}