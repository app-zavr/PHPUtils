<?php
/**
 * Created by PhpStorm.
 * User: temasnow
 * Date: 26.12.16
 * Time: 20:18
 */

namespace Appzavr\PHPUtils;

define('SYSTEM_INFORMATION', 0);
define('SYSTEM_NUMBERS', 1);

/**
 * Function formatting numbers to shorter version
 *
 * @param $number number to formatter
 * @param int $type
 * @param int $precision
 * @param string $locale
 * @return string
 */
function formatNumbers($number, $type = SYSTEM_INFORMATION, $precision = 2, $locale = LOCALE_RU)
{
    $numbers = [
        LOCALE_RU => ['тыс.', 'млн.', 'млрд.', 'трлн.', 'трлд.'],
        LOCALE_EN => ['k', 'mln.', 'bln.', 'trln.', 'trld.'],
    ];
    $units = [
        ['k', 'M', 'G', 'T', 'P'],
        $numbers[$locale],
    ];
    $separators = ['', ' '];
    $s = $separators[$type];

    if ($number <= 1000)
        return $number;
    elseif ($number > 1000 && $number < 1000000)
        return round($number / 1000, $precision) . $s . $units[$type][0];
    elseif ($number > 1000000 && $number < 1000000000)
        return round($number / 1000000, $precision) . $s . $units[$type][1];
    elseif ($number > 1000000000 && $number < 1000000000000)
        return round($number / 1000000000, $precision) . $s . $units[$type][2];
    elseif ($number > 1000000000000 && $number < 1000000000000000)
        return round($number / 1000000000000, $precision) . $s . $units[$type][3];
    elseif ($number > 1000000000000000)
        return round($number / 1000000000000000, $precision) . $s . $units[$type][4];

    return $number;
}

/**
 * Функция склонения числительных в русском языке
 *
 * @param int $number Число которое нужно просклонять
 * @param array $titles Массив слов для склонения
 * @param bool $isFormat - флаг форматирования числа
 * @param string $locale - локаль форматирования
 * @return string
 */
function declineNumber($number, $titles, $isFormat = true, $locale = LOCALE_RU)
{
    $cases = array(2, 0, 1, 1, 1, 2);
    if ($isFormat)
        $ret = formatNumbers($number, SYSTEM_NUMBERS, 2, $locale);
    else
        $ret = $number;

        return $ret . " " . $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
}