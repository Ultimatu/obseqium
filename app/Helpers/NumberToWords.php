<?php

namespace App\Helpers;

class NumberToWords
{
    private static array $units = [
        '', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf',
        'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize',
        'dix-sept', 'dix-huit', 'dix-neuf',
    ];

    private static array $tens = [
        '', 'dix', 'vingt', 'trente', 'quarante', 'cinquante',
        'soixante', 'soixante', 'quatre-vingt', 'quatre-vingt',
    ];

    public static function convert(float $amount): string
    {
        $amount = round($amount, 2);
        $euros = (int) $amount;
        $cents = (int) round(($amount - $euros) * 100);

        $result = self::convertInteger($euros).' euro'.(($euros > 1) ? 's' : '');

        if ($cents > 0) {
            $result .= ' et '.self::convertInteger($cents).' centime'.(($cents > 1) ? 's' : '');
        }

        return ucfirst($result);
    }

    private static function convertInteger(int $n): string
    {
        if ($n === 0) {
            return 'zéro';
        }

        if ($n < 0) {
            return 'moins '.self::convertInteger(-$n);
        }

        $result = '';

        if ($n >= 1_000_000) {
            $millions = (int) ($n / 1_000_000);
            $result .= self::convertInteger($millions).' million'.(($millions > 1) ? 's' : '');
            $n %= 1_000_000;
            if ($n > 0) {
                $result .= ' ';
            }
        }

        if ($n >= 1000) {
            $thousands = (int) ($n / 1000);
            $result .= ($thousands === 1 ? '' : self::convertInteger($thousands).' ').'mille';
            $n %= 1000;
            if ($n > 0) {
                $result .= ' ';
            }
        }

        if ($n >= 100) {
            $hundreds = (int) ($n / 100);
            if ($hundreds === 1) {
                $result .= 'cent';
            } else {
                $result .= self::$units[$hundreds].' cent';
            }
            $n %= 100;
            if ($n > 0) {
                $result .= ' ';
            } elseif ($hundreds > 1) {
                $result .= 's';
            }
        }

        if ($n > 0) {
            $result .= self::convertBelow100($n);
        }

        return $result;
    }

    private static function convertBelow100(int $n): string
    {
        if ($n < 20) {
            return self::$units[$n];
        }

        $ten = (int) ($n / 10);
        $unit = $n % 10;

        if ($ten === 7 || $ten === 9) {
            $unit += 10;

            return self::$tens[$ten].($unit === 11 ? '-et-' : '-').self::$units[$unit];
        }

        if ($unit === 0) {
            return self::$tens[$ten].($ten === 8 ? 's' : '');
        }

        if ($unit === 1 && $ten !== 8) {
            return self::$tens[$ten].'-et-un';
        }

        return self::$tens[$ten].'-'.self::$units[$unit];
    }
}
