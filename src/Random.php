<?php
/**
 * Created by PhpStorm.
 * User: temasnow
 * Date: 26.12.16
 * Time: 20:10
 */

namespace Appzavr\PHPUtils;

define('SEED_ALPHA', 0);
define('SEED_NUMERIC', 1);
define('SEED_ALPHANUM', 2);
define('SEED_HEXADEC', 3);
define('SEED_ALPHANUMCAPS', 4);

/*
 * Generate and return a random string
 *
 * The default string returned is 8 alphanumeric characters.
 *
 * The type of string returned can be changed with the output parameter.
 * Four types are available: alpha, numeric, alphanum and hexadec.
 *
 * If the output parameter does not match one of the above, then the string
 * supplied is used.
 *
 * @author      Aidan Lister <aidan@php.net>
 * @version     2.1.0
 * @link        http://aidanlister.com/2004/04/quick-and-easy-random-string-generation/
 * @param       int     $length  Length of string to be generated
 * @param       string  $seeds   Seeds string should be generated from
 */
function str_rand($length = 5, $output = SEED_ALPHANUMCAPS)
{
    // Possible seeds
    $outputs[0] = 'abcdefghijklmnopqrstuvwqyz';
    $outputs[1] = '0123456789';
    $outputs[2] = 'abcdefghijklmnopqrstuvwqyz0123456789';
    $outputs[3] = '0123456789abcdef';
    $outputs[4] = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    // Choose seed
    if (isset($outputs[$output])) {
        $output = $outputs[$output];
    }

    // Seed generator
    list($usec, $sec) = explode(' ', microtime());
    $seed = (float)$sec + ((float)$usec * 100000);
    mt_srand($seed);

    // Generate
    $str = '';
    $output_count = strlen($output);
    for ($i = 0; $length > $i; $i++) {
        $str .= $output{mt_rand(0, $output_count - 1)};
    }

    return $str;
}

function generateRandomSHA256($value = null)
{
    $str = hash('sha256', microtime() . $value . mt_rand(0, mt_rand(1, 1e6)));
    return $str;
}

function generateCodeRand()
{
    $len = 5;
    $short = "";
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $charslen = strlen($chars);
    for ($i = 0; $i < $len; $i++) {
        $rnd = rand(0, $charslen);
        $short .= substr($chars, $rnd, 1);
    }
    return $short;
}

/*
 * Very fast function, generate random string from hex seed
 */
function generateRandomHexString($length)
{
    // uses md5 & mt_rand. Not as "random" as it could be, but it works, and its fastest from my tests
    return str_shuffle(substr(str_repeat(md5(mt_rand()), 2 + $length / 32), 0, $length));
}