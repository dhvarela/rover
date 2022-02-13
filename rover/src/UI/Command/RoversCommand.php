<?php

namespace App\UI\Command;

use App\Rover\Planet\Application\PlanetCreator;
use App\Rover\Planet\Domain\Dimensions;
use App\Rover\Rover\Application\RoverCreator;
use App\Rover\Rover\Domain\Coordinate;
use App\Rover\Rover\Domain\Direction;
use App\Rover\Rover\Domain\Instructions;
use Exception;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableSeparator;
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
            ->addArgument('instructions', InputArgument::REQUIRED, 'Rover instructions');
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
            $planet = $this->planetCreator->execute(
                new Dimensions($input->getArgument('planet-dimensions'))
            );

            $coordinate = new Coordinate(
                $input->getArgument('pos-x'),
                $input->getArgument('pos-y')
            );

            $direction  = new Direction($input->getArgument('direction'));
            $instructions = new Instructions($input->getArgument('instructions'));

            $rover = $this->roverCreator->execute($planet, $coordinate, $direction, $instructions);
            $rover->executeInstructions();

            $io->definitionList(
                'History movements:', //TODO history movements
                new TableSeparator(),
                'Final rover position:',
                ['x' => $rover->getCoordinate()->getX()],
                ['y' => $rover->getCoordinate()->getY()]
            );
            $io->success("Rover expedition completed");

        } catch (InvalidArgumentException $e) {
            $io->error($e->getMessage());
            return Command::INVALID;
        } catch (Exception $e) {
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
