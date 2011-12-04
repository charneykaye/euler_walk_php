<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Node
 *
 * @author nickkaye
 */
class Node {

    public $id;
    public $x;
    public $y;
    public $altColor;
    public $adjacentTo;

    public function setAdjacentTo($list) {
        $this->adjacentTo = $list;
    }

}

?>
