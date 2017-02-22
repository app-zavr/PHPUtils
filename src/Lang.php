<?php
/**
 * Created by PhpStorm.
 * User: temasnow
 * Date: 27/12/2016
 * Time: 23:43
 */

namespace Appzavr\PHPUtils;

class Lang
{
    const LOCALE_RU = 'ru';
    const LOCALE_EN = 'en';
    const LOCALE_UK = 'uk';

    static function getBrowserLanguage($default = 'en', $languages = ['ru', 'en'])
    {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

        if (in_array($lang, $languages))
            return $lang;
        else
            return $default;
    }

    static function getLocaleSuffix() {

        $locale = Request::getValueForParameter('locale');
        $locale = substr($locale, 3, 2);

        if (strpos(strtolower($locale), 'ru') !== false || strpos(strtolower($locale), 'uk') !== false)
            $locale = 'ru';
        else
            $locale = 'en';

        return strtolower($locale);
    }
}