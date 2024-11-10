<?php

require_once "./includes/game_data.php";

$game_data = new GameData();
$data = $game_data->getData();
$board = $data["board"];
$current_player = $data["current_player"];

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./assets/css/main.css"/>
    <title>Tic Tac Toe</title>
</head>
<body>

<main class="full-screen">
    <h1>Tic Tac Toe</h1>

    <div class="container">
        <div class="players-container" id="players">
            <div class="player-box <?= $current_player === 'X' ? 'active' : '' ?>">
                X: <span class="player-score">0</span>
            </div>
            <div class="player-box <?= $current_player === 'O' ? 'active' : '' ?>">
                O: <span class="player-score">0</span>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="board-container" id="board">
            <?php foreach($board as $i => $item): ?>
            <div class="board-item" data-index="<?= ($i);?>">
                <?= $item; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <form method="post" action="./includes/handle-action.php" id="handle-form" class="main-form">
            <input type="text" name="player" value="<?= $current_player ?>" id="player" readonly="readonly" hidden="hidden"/>
            <input type="text" name="position" value="" id="position" readonly="readonly" hidden="hidden"/>
        </form>
    </div>
</main>

<script>
    window.onload = function() {
        const boardItems = Array.from(document.querySelectorAll('.board-item'));
        const form = document.getElementById('handle-form');
        const selectedPosition = document.getElementById('position');


        boardItems.forEach(item => {
            item.addEventListener('click', () => {
                const position = item.dataset.index;
                const itemValue = item.innerText.split(' ').join('');

                console.log({position, itemValue});

                if (!position || itemValue !== '') {
                    return;
                }

                selectedPosition.value = position;

                form.submit();
            });
        });
    }
</script>
</body>
</html>
