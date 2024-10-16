<?php

interface TowerOfHanoiInterface {
    public function getState(): array;
    public function move(int $from, int $to): void;
    public function resetGame(): void;
}

class TowerOfHanoi implements TowerOfHanoiInterface {
    /** @var array<int, array<int, int>> */
    private array $towers;
    private int $diskCount;
    private int $movesMade = 0;

    public function __construct(int $diskCount = 7) {
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
     * @return array{towers: array<int, array<int, int>>, moves_made: int, min_moves: int, status: string}
     */
    public function getState(): array {
        return [
            'towers' => $this->towers,
            'moves_made' => $this->movesMade,
            'status' => $this->getGameStatus()
        ];
    }

    /**
     * @param int $from
     * @param int $to
     * @throws InvalidArgumentException
     */
    public function move(int $from, int $to): void {
        if ($from < 1 || $from > 3 || $to < 1 || $to > 3) {
            throw new InvalidArgumentException("Invalid peg number. Must be 1, 2, or 3.");
        }

        if (!$this->isValidMove($from, $to)) {
            throw new InvalidArgumentException("Invalid move");
        }

        $disk = array_pop($this->towers[$from]);
        if ($disk !== null) {
            array_push($this->towers[$to], $disk);
            $this->movesMade++;
        }
    }

    /**
     * @param int $from
     * @param int $to
     * @return bool
     * @throws InvalidArgumentException
     */
    private function isValidMove(int $from, int $to): bool {
        if (!isset($this->towers[$from]) || !isset($this->towers[$to])) {
            throw new InvalidArgumentException("Invalid peg number");
        }

        if (empty($this->towers[$from])) {
            throw new InvalidArgumentException("No disk to move from peg $from");
        }

        if (!empty($this->towers[$to]) && end($this->towers[$from]) > end($this->towers[$to])) {
            throw new InvalidArgumentException("Cannot place a larger disk on top of a smaller one");
        }

        return true;
    }

    private function calculateMinMoves(): int {
        return pow(2, $this->diskCount) - 1;
    }

    private function getGameStatus(): string {
        return (count($this->towers[3]) == $this->diskCount) ? 'completed' : 'in_progress';
    }

    public function resetGame(): void {
        $this->initializeTowers();
        $this->movesMade = 0;
    }
}