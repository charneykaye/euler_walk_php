<?php

/**
 * Description of Board
 *
 * @author nickkaye
 */
class Board {

    public $nodes;
    public $edges;
    public $adjacencyLists;
    
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
