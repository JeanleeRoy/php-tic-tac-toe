<?php
final class GameData
{
    private array $data;
    private string $data_path = __DIR__ . "/data/game.json";

    public function __construct()
    {
        $this->data = json_decode(file_get_contents($this->data_path), true) ?? [];

        if (empty($this->data['board'])) {
            $this->clearBoard();
        }

        if (!$this->data['current_player']) {
            $this->setDefaultPlayer();
        }

        $this->saveData();
    }

    private function setDefaultPlayer(): void
    {
        $this->data['current_player'] = 'X';
    }

    private function clearBoard(): void
    {
        $this->data["board"] = [];
        for ($i = 0; $i < 9; $i++) {
            $this->data['board'][] = '';
        }
    }

    public function saveData(array|null $newData = null): void
    {
        $data = $newData ?? $this->data;

        if (empty($data)) {
            return;
        }

        file_put_contents($this->data_path, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function isValidPosition(int $position): bool
    {
        return $position >= 0 && $position < 9 && $this->data['board'][$position] === '';
    }

    public function setPlayerPosition(int $playerPosition, string|null $player = null): void {
        if (empty($player)) {
            $player = $this->data['current_player'];
        }

        $this->data['board'][$playerPosition] = $player;
    }

    public function setNextPlayer(): string
    {
        $nextTurn = $this->data['current_player'] === 'X' ? 'O' : 'X';
        $this->data['current_player'] = $nextTurn;

        return $nextTurn;
    }

    public function isBoardFull(): bool
    {
        return array_reduce($this->data['board'], function ($carry, $item) {
            return $carry && $item !== '';
        }, true);
    }

    public function resetGame(): void
    {
        $this->setDefaultPlayer();
        $this->clearBoard();
    }

    function __destruct()
    {
        $this->saveData();
    }
}