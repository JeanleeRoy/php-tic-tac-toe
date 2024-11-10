<?php

function goToIndex(): void
{
    header('Location: /', true, 303);
    die();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    goToIndex();
}

require_once './game_data.php';

$position = (int) filter_input(INPUT_POST, 'position', FILTER_SANITIZE_ENCODED);

$game_data = new GameData();
$data = $game_data->getData();
$current_player = $data["current_player"];

if (!is_numeric($position) || !$game_data->isValidPosition($position)) {
    echo "Invalid selected position";
    goToIndex();
}

$game_data->setPlayerPosition($position, $current_player);

$winner = $game_data->validateWinner();
$isFull = $game_data->isBoardFull();

if (!$winner && !$isFull) {
    $game_data->setNextPlayer();
}

goToIndex();