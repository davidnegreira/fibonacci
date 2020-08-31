<?php

namespace App\Service\FibonacciFactory;


use App\Service\FibonacciSequence;

class MonthFibonacci extends FibonacciType implements FibonacciInterface
{
    private $start;
    private $end;
    private $sequence;

    public function __construct(FibonacciSequence $sequence)
    {
        $this->sequence = $sequence;
        $this->calculeRange();
    }

    public function getSequence(): array
    {
        $this->sequence->setEnd($this->end);
        $result = [];

        foreach ($this->sequence as $item) {
            if ($item > $this->start){
                $result[] = $item;
            }
        }

        return $result;
    }

    private function calculeRange(): void
    {
        $this->start = strtotime('midnight first day of this month this year');
        $this->end = strtotime('midnight first day of next month this year -1 second');
    }

}