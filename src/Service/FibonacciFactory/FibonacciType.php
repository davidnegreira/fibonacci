<?php

namespace App\Service\FibonacciFactory;


use App\Service\FibonacciSequence;

abstract class FibonacciType
{
    public const MONTH = 1;
    public const YEAR = 2;
    public const CUSTOM = 3;

    public static function create($userSelection, ?string $startDate, ?string $endDate): ?FibonacciInterface
    {
        $sequence = new FibonacciSequence();

        switch ($userSelection) {
            case self::MONTH:
                return new MonthFibonacci($sequence);
            case self::YEAR:
                return new YearFibonacci($sequence);
            case self::CUSTOM;
                return new CustomFibonacci($sequence, $startDate, $endDate);
        }

        return null;
    }
}