<?php

namespace App\UI\Command;

use App\Rover\Planet\Application\PlanetCreator;
use App\Rover\Planet\Domain\Dimensions;
use App\Rover\Rover\Application\RoverCreator;
use App\Rover\Rover\Domain\Instructions;
use App\Rover\Shared\Domain\Coordinate;
use App\Rover\Shared\Domain\Direction;
use Exception;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RoversCommand extends Command
{
    protected static $defaultName = 'app:rover-start-mission';

    private $planetCreator;
    private $roverCreator;

    protected function configure(): void
    {
        $this
            ->setDescription('Start mission with Rover')
            ->addArgument('planet-dimensions', InputArgument::REQUIRED, 'Planet dimensions')
            ->addArgument('pos-x', InputArgument::REQUIRED, 'Rover coordinate X')
            ->addArgument('pos-y', InputArgument::REQUIRED, 'Rover coordinate Y')
            ->addArgument('direction', InputArgument::REQUIRED, 'Rover direction')
            ->addArgument('instructions', InputArgument::REQUIRED, 'Rover instructions')
            ->addArgument(
                'planet-obstacles',
                InputArgument::IS_ARRAY | InputArgument::OPTIONAL,
                'Planet obstacles (separate multiple coordinates with a space) eg. 2,1 5,5'
            );
    }

    public function __construct(PlanetCreator $planetCreator, RoverCreator $roverCreator)
    {
        parent::__construct();

        $this->planetCreator = $planetCreator;
        $this->roverCreator  = $roverCreator;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $planetObstacles = $this->getObstacles($input->getArgument('planet-obstacles'));

            $planet = $this->planetCreator->execute(
                new Dimensions($input->getArgument('planet-dimensions')),
                ...$planetObstacles
            );

            $rover = $this->roverCreator->execute(
                $planet,
                new Coordinate(
                    $input->getArgument('pos-x'),
                    $input->getArgument('pos-y')
                ),
                new Direction($input->getArgument('direction')),
                new Instructions($input->getArgument('instructions'))
            );

            $obstacle = $rover->executeInstructions();

            $io->definitionList(
                'Final rover position:',
                ['x' => $rover->getCoordinate()->getX()],
                ['y' => $rover->getCoordinate()->getY()],
                ['Direction' => $rover->getDirection()->value()]
            );
            if ($obstacle) {
                $io->warning(
                    sprintf(
                        'Obstacle found at: %d, %d',
                        $obstacle->getCoordinate()->getX(),
                        $obstacle->getCoordinate()->getY()
                    )
                );
            }
            $io->success("Rover expedition completed");

        } catch (InvalidArgumentException $e) {
            $io->error($e->getMessage());
            return Command::INVALID;
        } catch (Exception $e) {
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function getObstacles($planetObstacles): array
    {
        $obstacles = [];
        foreach ($planetObstacles as $obstacle) {
            $coordinates = explode(',', $obstacle);
            $obstacles[] = new Coordinate($coordinates[0], $coordinates[1]);
        }

        return $obstacles;
    }
}
