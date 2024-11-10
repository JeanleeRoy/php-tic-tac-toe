<?php

require_once "./includes/game_data.php";

$game_data = new GameData();
$data = $game_data->getData();
$board = $data["board"];
$current_player = $data["current_player"];
$scores = $data["scores"];

$winner_positions = $data["winner_positions"];
$is_board_full =$game_data->isBoardFull();

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
                X: <span class="player-score">
                    <?= $scores['X'] ?>
                </span>
            </div>
            <div class="player-box <?= $current_player === 'O' ? 'active' : '' ?>">
                O: <span class="player-score">
                    <?= $scores['O'] ?>
                </span>
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

        <div class="result-container <?= $is_board_full || count($winner_positions) ? 'active' : '' ?>">
            <?php if ($is_board_full && empty($winner_positions)): ?>
                <div>
                    <p class="big-player-result">
                        X O
                    </p>
                    <p class="text-result">
                        DRAW!
                    </p>
                </div>
            <?php elseif (count($winner_positions)): ?>
                <div id="winner-result" class="winner">
                    <p class="big-player-result">
                        <?= $current_player ?>
                    </p>
                    <p class="text-result">
                        WIN!
                    </p>
                </div>
            <?php endif ?>
        </div>
    </div>

    <div class="container">
        <form action="includes/handle-reset.php" method="post" class="reset-controls" id="reset-controls">
            <input type="text" name="intention" value="" id="reset-intention" readonly="readonly" hidden="hidden"/>
            <input class="btn" type="button" value="New attempt" data-reset="new-attempt" />
        </form>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"></script>
<script>
    window.onload = function() {
        const boardItems = Array.from(document.querySelectorAll('.board-item'));
        const form = document.getElementById('handle-form');
        const selectedPosition = document.getElementById('position');
        const winnerResult = document.getElementById('winner-result');

        boardItems.forEach(item => {
            item.addEventListener('click', () => {
                const position = item.dataset.index;
                const itemValue = item.innerText.split(' ').join('');

                if (!position || itemValue !== '' || winnerResult !== null) {
                    return;
                }

                selectedPosition.value = position;

                form.submit();
            });
        });

        if (winnerResult !== null) {
            setTimeout(() => {
                confetti({
                    particleCount: 100,
                    spread: 70,
                    origin: { y: 0.6 },
                });
            }, 760);
        }

        const resetControlsForm = document.getElementById('reset-controls');
        const resetIntention = document.getElementById('reset-intention');
        const resetButtons = document.querySelectorAll('[data-reset]');

        Array.from(resetButtons).forEach(btn => {
            btn.addEventListener('click', function () {
                const intention = btn.dataset.reset;

                resetIntention.setAttribute('value', intention);
                resetControlsForm.submit();
            });
        });
    }
</script>
</body>
</html>
