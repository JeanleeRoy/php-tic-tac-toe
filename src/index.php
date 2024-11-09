<?php

$board = [];

for ($i = 0; $i < 9; $i++) {
    $board[$i] = '';
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/main.css"/>
    <title>Tic Tac Toe</title>
</head>
<body>

<main class="full-screen">
    <h1>Tic Tac Toe</h1>

    <div class="container">
        <div class="players-container" id="players">
            <div class="player-box active">X: <span class="player-score">0</span></div>
            <div class="player-box">O: <span class="player-score">0</span></div>
        </div>

        <div class="board-container" id="board">
            <?php foreach($board as $i => $item): ?>
            <div class="board-item" data-index="<?= ($i);?>">

            </div>
            <?php endforeach; ?>
        </div>
    </div>

</main>

</body>
</html>
