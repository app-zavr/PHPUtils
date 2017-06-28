<?php
/**
 * Created by PhpStorm.
 * User: temasnow
 * Date: 26.12.16
 * Time: 20:41
 */

namespace Appzavr\PHPUtils;

require_once __DIR__ . '/../src/Numbers.php';

class NumberFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider formatNumberSystemProvider
     * @param $number
     * @param $precision
     * @param $expected
     */
    public function testFormatNumberRU($number, $precision, $expected)
    {
        $this->assertEquals($expected, formatNumbers($number, SYSTEM_INFORMATION, $precision, LOCALE_RU));
    }

    /**
     * @dataProvider formatNumberSystemProvider
     * @param $number
     * @param $precision
     * @param $expected
     */
    public function testFormatNumberEN($number, $precision, $expected)
    {
        $this->assertEquals($expected, formatNumbers($number, SYSTEM_INFORMATION, $precision, LOCALE_EN));
    }

    /**
     * @dataProvider formatNumberProvider
     * @param $locale
     * @param $number
     * @param $precision
     * @param $expected
     */
    public function testFormatNumber($locale, $number, $precision, $expected)
    {
        $this->assertEquals($expected, formatNumbers($number, SYSTEM_NUMBERS, $precision, $locale));
    }

    /**
     * @dataProvider declineNumberNonFormattedProvider
     * @param $number
     * @param $titles
     * @param $expected
     */
    public function testDeclineNumberNonFormatted($number, $titles, $expected)
    {
        $this->assertEquals($expected, declineNumber($number, $titles, false));
    }

    /**
     * @dataProvider declineNumberFormattedProvider
     * @param $number
     * @param $titles
     * @param $expected
     */
    public function testDeclineNumberFormatted($number, $titles, $expected)
    {
        $this->assertEquals($expected, declineNumber($number, $titles));
    }

    public function formatNumberSystemProvider()
    {
        return [
            [1, 0, '1'],
            [12, 0, '12'],
            [123, 0, '123'],
            [1234, 0, '1k'],
            [12345, 0, '12k'],
            [123456, 0, '123k'],
            [1234567, 0, '1M'],
            [12345678, 0, '12M'],
            [123456789, 0, '123M'],
            [1234567890, 0, '1G'],
            [12345678900, 0, '12G'],
            [123456789000, 0, '123G'],
            [1234567890000, 0, '1T'],
            [12345678900000, 0, '12T'],
            [123456789000000, 0, '123T'],
            [1234567890000000, 0, '1P'],
            [12345678900000000, 0, '12P'],
            [123456789000000000, 0, '123P'],
            [1, 2, '1'],
            [12, 2, '12'],
            [123, 2, '123'],
            [1234, 2, '1.23k'],
            [12345, 2, '12.35k'],
            [123456, 2, '123.46k'],
            [1234567, 2, '1.23M'],
            [12345678, 2, '12.35M'],
            [123456789, 2, '123.46M'],
            [1234567890, 2, '1.23G'],
            [12345678900, 2, '12.35G'],
            [123456789000, 2, '123.46G'],
        ];
    }

    public function formatNumberProvider()
    {
        return [
            [LOCALE_RU, 1, 0, '1'],
            [LOCALE_RU, 12, 0, '12'],
            [LOCALE_RU, 123, 0, '123'],
            [LOCALE_RU, 1234, 0, '1 тыс.'],
            [LOCALE_RU, 12345, 0, '12 тыс.'],
            [LOCALE_RU, 123456, 0, '123 тыс.'],
            [LOCALE_RU, 1234567, 0, '1 млн.'],
            [LOCALE_RU, 12345678, 0, '12 млн.'],
            [LOCALE_RU, 123456789, 0, '123 млн.'],
            [LOCALE_RU, 1234567890, 0, '1 млрд.'],
            [LOCALE_RU, 12345678900, 0, '12 млрд.'],
            [LOCALE_RU, 123456789000, 0, '123 млрд.'],
            [LOCALE_RU, 1234567890000, 0, '1 трлн.'],
            [LOCALE_RU, 12345678900000, 0, '12 трлн.'],
            [LOCALE_RU, 123456789000000, 0, '123 трлн.'],
            [LOCALE_RU, 1234567890000000, 0, '1 трлд.'],
            [LOCALE_RU, 12345678900000000, 0, '12 трлд.'],
            [LOCALE_RU, 123456789000000000, 0, '123 трлд.'],
            [LOCALE_RU, 1, 2, '1'],
            [LOCALE_RU, 12, 2, '12'],
            [LOCALE_RU, 123, 2, '123'],
            [LOCALE_RU, 1234, 2, '1.23 тыс.'],
            [LOCALE_RU, 12345, 2, '12.35 тыс.'],
            [LOCALE_RU, 123456, 2, '123.46 тыс.'],
            [LOCALE_RU, 1234567, 2, '1.23 млн.'],
            [LOCALE_RU, 12345678, 2, '12.35 млн.'],
            [LOCALE_RU, 123456789, 2, '123.46 млн.'],
            [LOCALE_RU, 1234567890, 2, '1.23 млрд.'],
            [LOCALE_RU, 12345678900, 2, '12.35 млрд.'],
            [LOCALE_RU, 123456789000, 2, '123.46 млрд.'],
            [LOCALE_RU, 1234567890000, 2, '1.23 трлн.'],
            [LOCALE_RU, 12345678900000, 2, '12.35 трлн.'],
            [LOCALE_RU, 123456789000000, 2, '123.46 трлн.'],
            [LOCALE_RU, 1234567890000000, 2, '1.23 трлд.'],
            [LOCALE_RU, 12345678900000000, 2, '12.35 трлд.'],
            [LOCALE_RU, 123456789000000000, 2, '123.46 трлд.'],

            // ------------------------------
            [LOCALE_EN, 1, 0, '1'],
            [LOCALE_EN, 12, 0, '12'],
            [LOCALE_EN, 123, 0, '123'],
            [LOCALE_EN, 1234, 0, '1 k'],
            [LOCALE_EN, 12345, 0, '12 k'],
            [LOCALE_EN, 123456, 0, '123 k'],
            [LOCALE_EN, 1234567, 0, '1 mln.'],
            [LOCALE_EN, 12345678, 0, '12 mln.'],
            [LOCALE_EN, 123456789, 0, '123 mln.'],
            [LOCALE_EN, 1234567890, 0, '1 bln.'],
            [LOCALE_EN, 12345678900, 0, '12 bln.'],
            [LOCALE_EN, 123456789000, 0, '123 bln.'],
            [LOCALE_EN, 1234567890000, 0, '1 trln.'],
            [LOCALE_EN, 12345678900000, 0, '12 trln.'],
            [LOCALE_EN, 123456789000000, 0, '123 trln.'],
            [LOCALE_EN, 1234567890000000, 0, '1 trld.'],
            [LOCALE_EN, 12345678900000000, 0, '12 trld.'],
            [LOCALE_EN, 123456789000000000, 0, '123 trld.'],
            [LOCALE_EN, 1, 2, '1'],
            [LOCALE_EN, 12, 2, '12'],
            [LOCALE_EN, 123, 2, '123'],
            [LOCALE_EN, 1234, 2, '1.23 k'],
            [LOCALE_EN, 12345, 2, '12.35 k'],
            [LOCALE_EN, 123456, 2, '123.46 k'],
            [LOCALE_EN, 1234567, 2, '1.23 mln.'],
            [LOCALE_EN, 12345678, 2, '12.35 mln.'],
            [LOCALE_EN, 123456789, 2, '123.46 mln.'],
            [LOCALE_EN, 1234567890, 2, '1.23 bln.'],
            [LOCALE_EN, 12345678900, 2, '12.35 bln.'],
            [LOCALE_EN, 123456789000, 2, '123.46 bln.'],
            [LOCALE_EN, 1234567890000, 2, '1.23 trln.'],
            [LOCALE_EN, 12345678900000, 2, '12.35 trln.'],
            [LOCALE_EN, 123456789000000, 2, '123.46 trln.'],
            [LOCALE_EN, 1234567890000000, 2, '1.23 trld.'],
            [LOCALE_EN, 12345678900000000, 2, '12.35 trld.'],
            [LOCALE_EN, 123456789000000000, 2, '123.46 trld.'],
        ];
    }

    public function declineNumberNonFormattedProvider()
    {
        $titles = ['стул', 'стула', 'стульев'];
        return [
            [0, $titles, '0 стульев'],
            [1, $titles, '1 стул'],
            [2, $titles, '2 стула'],
            [4, $titles, '4 стула'],
            [5, $titles, '5 стульев'],
            [9, $titles, '9 стульев'],
            [10, $titles, '10 стульев'],
            [11, $titles, '11 стульев'],
            [55, $titles, '55 стульев'],
            [99, $titles, '99 стульев'],
            [100, $titles, '100 стульев'],
            [10000, $titles, '10000 стульев'],
        ];
    }

    public function declineNumberFormattedProvider()
    {
        $titles = ['стул', 'стула', 'стульев'];
        return [
            [0, $titles, '0 стульев'],
            [1, $titles, '1 стул'],
            [2, $titles, '2 стула'],
            [4, $titles, '4 стула'],
            [5, $titles, '5 стульев'],
            [9, $titles, '9 стульев'],
            [10, $titles, '10 стульев'],
            [11, $titles, '11 стульев'],
            [55, $titles, '55 стульев'],
            [99, $titles, '99 стульев'],
            [100, $titles, '100 стульев'],
            [10000, $titles, '10 тыс. стульев'],
        ];
    }

}
