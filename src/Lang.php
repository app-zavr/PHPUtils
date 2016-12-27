<?php
/**
 * Created by PhpStorm.
 * User: temasnow
 * Date: 27/12/2016
 * Time: 23:43
 */

function getBrowserLanguage($default = 'en', $languages = ['ru', 'en'])
{
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

    if (array_key_exists($lang, $languages))
        return $lang;
    else
        return $default;
}