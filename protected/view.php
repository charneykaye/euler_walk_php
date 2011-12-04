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
class view {
    const squareWidth = 20;
    const squareHeight = 20;

    public function traceBoard($board) {
        $out = "";
        foreach ($board->nodes as $id => $node)
            $out .= self::div(array(
                        "class" => "square" . ($node->altColor ? " alt" : ""), // alt or not
                        "style" => "width:" . $board->squareSize . "px;  height:" . $board->squareSize . "px;" // square
                            ), "<Br/>" . $node->id); // id number of each square
        return self::div(array(
                    "class" => "board",
                    "style" => "width:" . ($board->width * $board->squareSize) . "px;  height:" . ($board->height * $board->squareSize) . "px;"
                        ), $out);
    }
    
    public function traceBoardAdjacencyLists($board) {
        $out = "";
        foreach ($board->nodes as $id=>$node)
            $out .= self::p(array(
                        "class" => "adjacentTo" . ($node->altColor ? " alt" : ""), // alt or not
                            ), $node->id . ": " . implode("&nbsp;",$node->adjacentTo)); // id number of each square
        return self::div(array(
                    "class" => "adjacencyLists"
                        ), $out);
    }

    public function div($attr, $content) {
        return self::tag("div", $attr, $content);
    }

    public function p($attr, $content) {
        return self::tag("p", $attr, $content);
    }

    public function tag($tag, $attr, $content) {
        $out = "<" . $tag . " ";
        foreach ($attr as $key => $val)
            $out .= $key . "=\"" . $val . "\" ";
        $out .= ">"
                . $content
                . "</" . $tag . ">";
        return $out;
    }

    public function showMicrotime($ms) {
        return self::div(array(
                    "class" => "microtime",
                        ), "[ " . $ms . " ]"
        );
    }

}

?>
