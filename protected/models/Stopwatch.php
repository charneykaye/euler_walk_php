<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Stopwatch
 *
 * @author nickkaye
 */
class Stopwatch {

    private $timeStart;

    public function start() {
        $this->timeStart = microtime(true);
    }

    public function lap() {
        return floor((microtime(true) - $this->timeStart)*1000);
    }

}

?>
