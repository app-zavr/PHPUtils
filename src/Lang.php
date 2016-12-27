<?php
/**
 * Created by PhpStorm.
 * User: temasnow
 * Date: 27/12/2016
 * Time: 23:43
 */


define('LOCALE_RU', 'ru');
define('LOCALE_EN', 'en');
define('LOCALE_UK', 'uk');

function getBrowserLanguage($default = 'en', $languages = ['ru', 'en'])
{
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

    if (in_array($lang, $languages))
        return $lang;
    else
        return $default;
}