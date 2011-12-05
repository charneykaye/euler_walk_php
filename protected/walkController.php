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
    public $nodes_id;
    public $rules;

    public function __construct($board, $rules, $stopwatch) {
        $this->board = $board;
        $this->rules = $rules;
        $this->nodes_id = array();
        $this->stopwatch = $stopwatch;
    }

    public function run() {
        echo view::walkHeader(); // show header for Walk controller
        if ($this->rule("successCircular"))  { // if it's circular path success criteria, only need to cycle beginning with the first node
            $nodes = util::firstKeyValFrom($this->board->nodes);
        }      else // otherwise cycle through all nodes
            $nodes = $this->board->nodes;
        foreach ($nodes as $node) { // for each node on the board
            echo view::walkNodeHeader($node); // show node header
            $walk = new Walk;
            $walk->replicate($this);
            $walk->traverseAll($node->id);
            echo view::stopwatch($this->stopwatch);
        }
        echo view::walkFooter(); // show header for Walk controller
    }

    public function rule($key, $value=null) {
        if ($value !== null)
            return $this->rules[$key] = $value;
        if (isset($this->rules[$key]))
            return $this->rules[$key];
    }    
    
}

?>
