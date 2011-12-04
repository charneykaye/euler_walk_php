<?php

$defaultBoardWidth = 3;
$defaultBoardHeight = 3;
$boardSquareSize = 60;

include_once("protected/util.php");
include_once("protected/view.php");

include_once("protected/models/Node.php");
include_once("protected/models/Edge.php");
include_once("protected/models/Board.php");
include_once("protected/models/Stopwatch.php");

$stopwatch = new Stopwatch();
$stopwatch->start();

?><html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/walk.css" type="text/css" media="all" />
        <title></title>
    </head>
    <body>
        <?php
        
        $board = new Board(
                        util::requestVar("boardWidth", $defaultBoardWidth),
                        util::requestVar("boardHeight", $defaultBoardHeight),
                        util::requestVar("boardSquareSize", $boardSquareSize)
        ); ?>        
        
        <h1>Board</h1>
        <p class='subtitle'><?php echo $board->width; ?> x <?php echo $board->height; ?> nodes, assigned the following <strong>id</strong> numbers:</p>
        <?php echo view::traceBoard($board); ?>

        <h1>Edges</h1>        
        <?php echo "<p>" . count($board->edges) . " edges.</p>" ?>

        <h1>Adjacency Lists</h1>
        <?php echo view::traceBoardAdjacencyLists($board); ?>

        <h1>Walks</h1>
        <?php echo walk::board($board); ?>
        
    </body>
</html>
