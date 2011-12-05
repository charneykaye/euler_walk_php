<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of walk
 *
 * @author nickkaye
 */
class walkController {

    public $stopwatch;
    public $rules;

    public function __construct($board, $rules, $stopwatch) {
        $this->board = $board;
        $this->rules = $rules;
        $this->stopwatch = $stopwatch;
    }

    public function run() {
        echo view::walkHeader(); // show header for Walk controller
        foreach ($this->board->nodes as $node) { // for each node on the board
            echo view::walkNodeHeader($node); // show node header
            $walk = new Walk;
            $walk->setBoard($this->board);
            $walk->setRules($this->rules);
            $walk->setNodesId();
            $walk->traverseAll($node->id);
            echo view::stopwatch($this->stopwatch);
        }
        echo view::walkFooter(); // show header for Walk controller
    }

}

?>
