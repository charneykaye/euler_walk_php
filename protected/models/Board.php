<?php

/**
 * Description of Board
 *
 * @author nickkaye
 */
class Board {

    public $width;
    public $height;
    public $squareSize;
    
    public $nodes;
    public $edges;
    public $adjacencyLists;

    public function __construct($width = 3, $height = 3, $squareSize = 20) {
        $this->width = $width;
        $this->height = $height;
        $this->squareSize = $squareSize;
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
            if ($node->x > 1 && $node->y > 1)
                $out[] = new Edge($node->id, $node->id - $this->width - 1); // above left
            if ($node->y > 1)
                $out[] = new Edge($node->id, $node->id - $this->width); // above
            if ($node->y > 1 && $node->x < $this->width)
                $out[] = new Edge($node->id, $node->id - $this->width + 1); // above right
            if ($node->x < $this->width)
                $out[] = new Edge($node->id, $node->id + 1);  // right
            if ($node->y < $this->height && $node->x < $this->width)
                $out[] = new Edge($node->id, $node->id + $this->width + 1); // below right
            if ($node->y < $this->height)
                $out[] = new Edge($node->id, $node->id + $this->width); // below
            if ($node->y < $this->height && $node->x > 1)
                $out[] = new Edge($node->id, $node->id + $this->width - 1); // below left
        }
        return $this->edges = $out;
    }

    public function createAdjacencyLists() {
        if ($this->nodes==null) $this->createNodes();
        if ($this->edges==null) $this->createEdges();
        $lists = array();
        foreach ($this->edges as $edge)
            if (isset($lists[$edge->a_id]))
                $lists[$edge->a_id][] = $edge->b_id;
            else
                $lists[$edge->a_id] = array($edge->b_id);
            foreach($lists as $node_id=>$node_list)
                $this->nodes[$node_id]->setAdjacentTo($node_list);
    }
    
}

?>
