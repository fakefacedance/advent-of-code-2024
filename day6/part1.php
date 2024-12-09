<?php

require __DIR__ . '/vendor/autoload.php';
use Ds\Set;

class Part1
{
    private array $map;
    private Set $visited;
    private array $direction = ['x' => -1, 'y' => 0];
    private array $currentPos = ['x' => 0, 'y' => 0];

    public function __construct(string $inputPath)
    {
        $this->visited = new Set();
        $input = trim(file_get_contents($inputPath));
        $this->map = explode("\n", $input);

        foreach ($this->map as $rowIndex => $row) {
            $posY = strpos($row, "^");
            if ($posY !== false) {
                $this->currentPos = ['x' => $rowIndex, 'y' => $posY];
                break;
            }
        }
    }

    public function getDistinctVisitedPositions(): int
    {
        return $this->visited->count();
    }

    public function patrol(): void
    {
        $outOfBounds = false;
        while (!$outOfBounds) {
            $obstaclePos = $this->findObstaclePos();
            if (empty($obstaclePos)) {
                $outOfBounds = true;
                break;
            }
            $this->changeDirection();
        }
    }

    private function findObstaclePos(): array
    {
        while (true) {
            $this->visited->add($this->currentPos);

            $x = $this->currentPos['x'] + $this->direction['x'];
            $y = $this->currentPos['y'] + $this->direction['y'];
            if ($this->isOutOfBounds(['x' => $x, 'y' => $y])) {
                return [];
            }
            if ($this->map[$x][$y] === '#') {
                return ['x' => $x, 'y' => $y];
            }
            $this->currentPos['x'] = $x;
            $this->currentPos['y'] = $y;
        }

        return [];
    }

    private function isOutOfBounds(array $pos): bool
    {
        return $pos['x'] >= count($this->map) || $pos['y'] >= strlen($this->map[0]) || $pos['x'] < 0 || $pos['y'] < 0;
    }

    private function changeDirection(): void
    {
        $this->direction = match ($this->direction) {
            ['x' => -1, 'y' => 0] => ['x' => 0, 'y' => 1],
            ['x' => 0, 'y' => 1] => ['x' => 1, 'y' => 0],
            ['x' => 1, 'y' => 0] => ['x' => 0, 'y' => -1],
            ['x' => 0, 'y' => -1] => ['x' => -1, 'y' => 0],
        };
    }
}

$part1 = new Part1('./input.txt');
$part1->patrol();

echo "Visited: {$part1->getDistinctVisitedPositions()}\n";
