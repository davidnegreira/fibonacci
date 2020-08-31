<?php

namespace App\Service\FibonacciFactory;


abstract class FibonacciType
{
    public const MONTH = 1;
    public const YEAR = 2;
    public const CUSTOM = 3;


    public static function create($userSelection): ?FibonacciInterface
    {
        switch ($userSelection) {
            case self::MONTH:
                return new MonthFibonacci();
            case self::YEAR:
                return new YearFibonacci();
            case self::CUSTOM;
                return new CustomFibonacci();
        }

        return null;
    }
}