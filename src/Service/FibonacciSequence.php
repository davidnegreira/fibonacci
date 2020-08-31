<?php

namespace App\Service;

use Iterator;

class FibonacciSequence implements Iterator
{
    private $previous = 1;
    private $current = 0;
    private $key = 0;
    private $end=0;

    public function __construct()
    {
        $this->rewind();
    }

    public function key()
    {
        return $this->key;
    }

    public function current(): int
    {
        return $this->current;
    }

    public function next(): void
    {
        $tempCurrent = $this->current;
        $this->current += $this->previous;
        $this->previous = $tempCurrent;
        $this->key++;
    }

    public function rewind(): void
    {
        $this->previous = 1;
        $this->current = 0;
        $this->key = 0;
    }

    public function valid(): bool
    {
        return $this->current <= $this->end;
    }

    public function setEnd($end): void
    {
        $this->end = $end;
    }
}


