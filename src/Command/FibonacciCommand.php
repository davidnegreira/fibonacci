<?php

namespace App\Command;

use App\Service\FibonacciFactory\FibonacciType;
use DateTime;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
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
        date_default_timezone_set("UTC");

        $io = new SymfonyStyle($input, $output);
        $table=[];
        $startDate = null;
        $endDate = null;

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

        if($indexOption === 3){
            $question = new Question('Fecha de inicio: ');
            $startDate = $this->askDate($question, $helper, $input, $output);

            $question = new Question('Fecha de Fin: ');
            $endDate = $this->askDate($question, $helper, $input, $output);
        }

        $fibonacci = FibonacciType::create($indexOption, $startDate, $endDate);

        if ($fibonacci === null){
            $io->error("Error al generar el listado, la opción no seleccionada no es válida");
        }

        foreach ($fibonacci->getSequence() as $item) {
            $table[][] = $item;
        }

        $io->table(["resultados"], $table);

        return 0;
    }


    protected function askDate(Question $question,
                               QuestionHelper $helper,
                               InputInterface $input,
                               OutputInterface $output): string
    {
        $question->setValidator(static function ($answer) {
            if (!DateTime::createFromFormat("Y-m-d H:i:s", $answer)) {
                throw new RuntimeException(
                    'La fecha tiene que estar en formato AAA-MM-DD HH:MM:SS'
                );
            }

            return $answer;
        });

        $question->setMaxAttempts(5);

        return $helper->ask($input, $output, $question);
    }
}
