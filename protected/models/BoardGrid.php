<?php

include_once("Board.php");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BoardGrid
 *
 * @author nickkaye
 */
class BoardGrid extends Board {

    public $width;
    public $height;
    public $squareSize;
    public $title="Grid Up/Down/Left/Right Adjacency";
 
    public function __construct() {
    }
    
    public function create() {
        $this->createNodes();
        $this->createEdges();
        $this->createAdjacencyLists();        
    }
    
   /**
     * Generate an array of all the board squares,
     * each represented in an array of keys for x and y position,
     * and "alt", whether or not the square is displayed alternate color
     * 
     * @return array
     */
    public function createNodes() {
        $id = 1; // id starts at 1
        $out = array();
        for ($y = 1; $y <= $this->height; $y++) {  // each y
            $alt = !(floor($y / 2) == $y / 2); // set odd for first x
            for ($x = 1; $x <= $this->width; $x++) { // each x
                $node = new Node();
                $node->x = $x;
                $node->y = $y;
                $node->altColor = $alt;
                $node->id = $id;
                $out[$node->id] = $node;
                $id++; // next id
                $alt = !$alt; // toggle odd
            }
        }
        return $this->nodes = $out;
    }

    /**
     * Generate an array of Edges, representing the adjacency of squares on the board.
     */
    public function createEdges() {
        if ($this->nodes==null) $this->createNodes();
        $nodes = $this->nodes;
        $out = array();
        foreach ($nodes as $node) {
            if ($node->x > 1)
                $out[] = new Edge($node->id, $node->id - 1);  // left
            if ($node->y > 1)
                $out[] = new Edge($node->id, $node->id - $this->width); // above
            if ($node->x < $this->width)
                $out[] = new Edge($node->id, $node->id + 1);  // right
            if ($node->y < $this->height)
                $out[] = new Edge($node->id, $node->id + $this->width); // below
        }
        return $this->edges = $out;
    }    
    
}

?>
