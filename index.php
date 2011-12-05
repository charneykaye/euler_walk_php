<?php
ini_set('max_execution_time', 3600);

$defaultBoardWidth = 3;
$defaultBoardHeight = 3;
$defaultSuccessCircular = true;
$boardSquareSize = 60;

include_once("protected/util.php"); // utilities
include_once("protected/view.php"); // view
include_once("protected/walkController.php"); // walk (a board)

include_once("protected/models/Node.php"); // Node model
include_once("protected/models/Edge.php"); // Edge model

include_once("protected/models/Walk.php"); // Walk model

include_once("protected/models/Stopwatch.php"); // Stopwatch model

$stopwatch = new Stopwatch(); // instantiate Stopwatch
$stopwatch->start(); // start the stopwatch
?><html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/walk.css" type="text/css" media="all" />
        <script language="javascript" src="js/scrollToBottom.js" />
        <title></title>
    </head>
    <body>
        <?php
        // VARIABLES
        $board = util::requestVar("board", "grid");
        $rules = array(
            "successCircular" => util::requestVar("successCircular", $defaultSuccessCircular),
        );

        switch ($board) {
            case "gridWithDiagonal":
                include_once("protected/models/BoardGridWithDiagonal.php"); // Board model
                $board = new BoardGridWithDiagonal;
                break;
            case "grid":
                include_once("protected/models/BoardGrid.php"); // Board model
                $board = new BoardGrid;
                break;
            default:
                die("no board.  exit.");
                break;
        }
        ?>        

        <?php
        $board->rules = $rules;
        $board->width = util::requestVar("boardWidth", $defaultBoardWidth);
        $board->height = util::requestVar("boardHeight", $defaultBoardHeight);
        $board->squareSize = util::requestVar("boardSquareSize", $boardSquareSize);
        $board->create();
        echo view::traceAdjacencyLists($board); 
        echo view::traceBoard($board);
        echo view::traceEdges($board); 
        echo view::stopwatch($stopwatch);
        ?>

        <?php
        $walk = new walkController($board, $rules, $stopwatch);
        $walk->run();
        ?>

    </body>
</html>
