<?php

interface TowerOfHanoiInterface {
    public function getState(): array;
    public function move(int $from, int $to): void;
}

class TowerOfHanoi implements TowerOfHanoiInterface {
    /** @var array<int, array<int, int>> */
    private array $towers;
    private int $diskCount;

    public function __construct(int $diskCount = 3) {
        $this->diskCount = $diskCount;
        $this->initializeTowers();
    }

    private function initializeTowers(): void {
        $this->towers = [
            1 => range($this->diskCount, 1),
            2 => [],
            3 => []
        ];
    }

    /**
     * @return array{towers: array<int, array<int, int>>, moves: int, status: string}
     */
    public function getState(): array {
        return [
            'towers' => $this->towers,
            'moves' => $this->calculateMoves(),
            'status' => $this->getGameStatus()
        ];
    }

    /**
     * @param int $from
     * @param int $to
     * @throws Exception
     */
    public function move(int $from, int $to): void {
        if (!$this->isValidMove($from, $to)) {
            throw new Exception("Invalid move");
        }

        $disk = array_pop($this->towers[$from]);
        if ($disk !== null) {
            array_push($this->towers[$to], $disk);
        }
    }

    private function isValidMove(int $from, int $to): bool {
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

    private function calculateMoves(): int {
        return pow(2, $this->diskCount) - 1;
    }

    private function getGameStatus(): string {
        return (count($this->towers[3]) == $this->diskCount) ? 'completed' : 'in_progress';
    }
}