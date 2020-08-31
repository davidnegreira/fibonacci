<?php

namespace App\Command;

use App\Service\FibonacciFactory\FibonacciType;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;


class FibonacciCommand extends Command
{
    protected static $defaultName = 'app:fibonacci';

    protected function configure(): void
    {
        $this
            ->setDescription('Calculate Fibonacci Sequence ');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $options = [1 => 'Mes actual', 2 => 'Año actual', 3 => 'Rango de fechas'];
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Seleccione el tipo de lista Fibonacci que quiere generar',
            $options,
            1
        );
        $question->setErrorMessage('La opción %s no es valida.');

        $selectedOption = $helper->ask($input, $output, $question);
        $indexOption = array_search($selectedOption, $options, true);

        $output->writeln('You have just selected: ' . $indexOption);

        $fibonacci = FibonacciType::create($indexOption);

        if ($fibonacci === null){
            $io->error("Error al generar el listado, la opción no seleccionada no es válida");
        }

        $fibonacci->getSequence();

        return 0;
    }
}
