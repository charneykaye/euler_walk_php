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
        return "<h2>Board: " . $board->title . "</h2>"
                . "<p class='subtitle'>" . $board->width . " x " . $board->height . " nodes, assigned the following <strong>id</strong> numbers:</p>"
                . self::div(array(
                    "class" => "board",
                    "style" => "width:" . ($board->width * $board->squareSize) . "px;  height:" . ($board->height * $board->squareSize) . "px;"
                        ), $out);
    }

    public function traceEdges($board) {
        return "<h2>Edges</h2>"
                . "<p>" . count($board->edges) . " edges.</p>";
    }

    public function traceAdjacencyLists($board) {
        $out = "";
        foreach ($board->nodes as $id => $node)
            $out .= self::p(array(
                        "class" => "adjacentTo" . ($node->altColor ? " alt" : ""), // alt or not
                            ), $node->id . ": " . implode("&nbsp;", $node->adjacentTo)); // id number of each square
        return
                self::div(array(
                    "class" => "adjacencyLists"
                        ), " <h2>Adjacency Lists</h2>" . $out);
    }

    public function walkHeader() {
        return
                "<span class='walkController'>"
                . "<h1>Walks</h1>";
    }

    public function walkFooter() {
        return "</span>";
    }

    public function walkNodeHeader($node) {
        return "<h2>Node" . $node->id . "</h2>";
    }

    public function walkPathInProgress($walk) {
        $out = implode("&nbsp;", $walk->nodes_id);
        return
                self::p(array(
                    "class" => "walkPath"
                        ), $out);
    }

    public function walkPathSuccess($walk) {
        $out = implode("&nbsp;", $walk->nodes_id);
        return
                self::p(array(
                    "class" => "walkPath success"
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

    public function stopwatch($stopwatch) {
        return "<br/>" . self::div(array(
                    "class" => "microtime",
                        ), "[" . $stopwatch->lap() . "ms]"
        );
    }

}

?>
