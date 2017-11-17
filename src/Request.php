<?php
/**
 * Created by PhpStorm.
 * User: temasnow
 * Date: 07.02.17
 * Time: 0:07
 */

namespace Appzavr\PHPUtils;

class Request {
    // TODO Прроверить на SQL инъекции и экранирование параметров
    static function getValueForParameter($value, $isString = true, $isNull = true, $checkKey = true)
    {
        if ($checkKey) {
            if (!isset($_GET[$value])) {
                Response::error(ERROR_REQUEST_NOT_ENOUGH_PARAMS, [$value]);
            }
        }

        @$valueGet = addslashes($_GET[$value]);

        if (empty($valueGet) && ($valueGet != 0)) {
            if (!$isNull)
                Response::error(ERROR_REQUEST_NOT_NULL_VALUE);
        } else {
            if (!empty($valueGet) || ($valueGet == 0))
                return $valueGet;
        }

        return $isString ? '' : 0;
    }

    static function postValueForParameter($value, $isString = true, $isNull = true, $checkKey = true)
    {
        if ($checkKey) {
            if (!isset($_POST[$value])) {
                Response::error(ERROR_REQUEST_NOT_ENOUGH_PARAMS, [$value]);
            }
        }

        @$valuePost = addslashes($_POST[$value]);

        if (empty($valuePost) && ($valuePost != 0)) {
            if (!$isNull)
                Response::error(ERROR_REQUEST_NOT_NULL_VALUE);
        } else {
            if (!empty($valuePost) || ($valuePost == 0))
                return $valuePost;
        }

        return $isString ? '' : 0;
    }
}