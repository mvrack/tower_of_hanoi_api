<?php

class TowerOfHanoi {
    private $towers;
    private $diskCount;

    public function __construct($diskCount = 3) {
        $this->diskCount = $diskCount;
        $this->initializeTowers();
    }

    private function initializeTowers() {
        $this->towers = [
            1 => range($this->diskCount, 1),
            2 => [],
            3 => []
        ];
    }

    public function getState() {
        return [
            'towers' => $this->towers,
            'moves' => $this->calculateMoves(),
            'status' => $this->getGameStatus()
        ];
    }

    public function move($from, $to) {
        if (!$this->isValidMove($from, $to)) {
            throw new Exception("Invalid move");
        }

        $disk = array_pop($this->towers[$from]);
        array_push($this->towers[$to], $disk);
    }

    private function isValidMove($from, $to) {
        if (!isset($this->towers[$from]) || !isset($this->towers[$to])) {
            return false;
        }

        if (empty($this->towers[$from])) {
            return false;
        }

        if (!empty($this->towers[$to]) && end($this->towers[$from]) > end($this->towers[$to])) {
            return false;
        }

        return true;
    }

    private function calculateMoves() {
        return pow(2, $this->diskCount) - 1;
    }

    private function getGameStatus() {
        return (count($this->towers[3]) == $this->diskCount) ? 'completed' : 'in_progress';
    }
}