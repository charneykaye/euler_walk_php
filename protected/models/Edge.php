<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Edge
 *
 * @author nickkaye
 */
class Edge {

    public function __construct($a_id,$b_id) {
        $this->a_id = $a_id;
        $this->b_id = $b_id;
    }
    
    public $a_id;
    public $b_id;

}

?>
