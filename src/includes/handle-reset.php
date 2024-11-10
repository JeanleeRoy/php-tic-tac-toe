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

$reset_intention = filter_input(INPUT_POST, 'intention', FILTER_SANITIZE_ENCODED);

$game_data = new GameData();

if ($reset_intention === 'new-attempt') {
    $game_data->setNewAttempt();
}

goToIndex();