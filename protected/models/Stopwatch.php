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

    private $microtime;

    public function start() {
        $this->microtime = microtime();
    }

    public function check() {
        return microtime() - $this->microtime;
    }

}

?>
