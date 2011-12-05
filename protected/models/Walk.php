<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Walk
 *
 * @author nickkaye
 */
class Walk {

    public $board;
    public $rules;
    public $nodes_id;

    public function __construct($walk=null) {
        if ($walk != null)
            $this->replicate($walk);
    }

    /**
     *
     * @param Walk $walk 
     */
    public function traverseAll($node_id) {
        $this->nodes_id[] = $node_id; // add the node id

        if ($this->meetsSuccessCriteria())
            echo view::walkPathSuccess($this); // successful walk    
// echo view::walkPathInProgress($this); // walk in progress (possibility of success)

        $node = $this->board->nodes[$node_id];
        foreach ($node->adjacentTo as $node_id)
            if (!in_array($node_id, $this->nodes_id)) { // if not already visited
                $walk = new Walk;
                $walk->replicate($this);
                $walk->traverseAll($node_id); // continue this walk to an adjacent node
            }
    }

    /**
     *
     * @return boolean
     */
    public function meetsSuccessCriteria() {
        return (
                $this->successCountTotal()
                && $this->successCircular());
    }

    public function successCountTotal() {
        // if the count of nodes in our walk is equal to the count of nodes on the board
        return ( count($this->nodes_id) == count($this->board->nodes));
    }

    public function successCircular() {
        if ($this->rule("successCircular"))
        // if the last node is adjacent to the first node (circular path)
        return in_array(
                        util::firstValFrom($this->nodes_id),
                        $this->board->nodes[ util::lastValFrom($this->nodes_id)]
                        ->adjacentTo)

        ;
        // else return false
        return true;
    }

    /**
     *
     * @param array $board 
     */
    public function setBoard($board) {
        $this->board = $board;  // board
    }

    /**
     *
     * @param array $rules 
     */
    public function setRules($rules) {
        if (is_array($rules))
            $this->rules = $rules;  // rules
        else
            $this->rules = array();
    }

    /**
     *
     * @param array $nodes_id
     */
    public function setNodesId($nodes_id=null) {
        if (is_array($nodes_id))
            $this->nodes_id = $nodes_id;
        else
            $this->nodes_id = array();
    }

    public function rule($key, $value=null) {
        if ($value !== null)
            return $this->rules[$key] = $value;
        if (isset($this->rules[$key]))
            return $this->rules[$key];
    }

    /**
     *
     * @param Walk $walk 
     */
    public function replicate($walk) {
        $this->setBoard($walk->board);
        $this->setRules($walk->rules);
        $this->setNodesId($walk->nodes_id);
    }

}

?>