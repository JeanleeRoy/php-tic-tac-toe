<?php
final class GameData
{
    private array $data;
    private string $data_path = __DIR__ . "/data/game.json";

    public function __construct()
    {
        $this->data = json_decode(file_get_contents($this->data_path), true) ?? [];

        if (empty($this->data['board'])) {
            for ($i = 0; $i < 9; $i++) {
                $this->data['board'][] = '';
            }
        }

        if (!$this->data['current_player']) {
            $this->data['current_player'] = 'X';
        }

        $this->saveData();
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
}