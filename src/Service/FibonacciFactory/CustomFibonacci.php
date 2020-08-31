<?php

namespace App\Service\FibonacciFactory;


use App\Service\FibonacciSequence;


class CustomFibonacci extends FibonacciType implements FibonacciInterface
{
    private $startDate;
    private $endDate;
    private $sequence;
    private $start;
    private $end;

    public function __construct(FibonacciSequence $sequence, $startDate, $endDate)
    {
        $this->sequence = $sequence;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
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
        $this->start = strtotime($this->startDate);
        $this->end = strtotime($this->endDate);
    }

    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    public function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }

}