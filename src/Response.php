<?php
/**
 * Created by PhpStorm.
 * User: temasnow
 * Date: 26.12.16
 * Time: 23:11
 */

namespace Appzavr\PHPUtils;

define("STATUS_OK", "OK");
define("STATUS_ERROR", "ERROR");
define('PAYLOAD', 'payload');
define('RESULT_CODE', 'resultCode');

define('ERROR', 'error');
define('MESSAGE_ERROR', 'message');
define('MESSAGE_OK', 'message');
define('ERROR_CODE', 'errorCode');

define('ERROR_REQUEST_NOT_ENOUGH_PARAMS', -100);
define('ERROR_REQUEST_NOT_NULL_VALUE', -101);

class Response
{
    function response($data)
    {
        header('Content-type: text/json');
        header('Content-type: application/json');

        print_r(json_encode($data, TRUE));
        exit;
    }

    static function ok($params)
    {
        $retVal = array();

        if (is_array($params)) {
            $retVal[RESULT_CODE] = STATUS_OK;
            $retVal[PAYLOAD] = $params;
        } elseif (is_a($params, 'MongoCursor')) {
            $data = [];
            while ($params->hasNext()) {
                $data[] = $params->getNext();
            }

            $retVal[RESULT_CODE] = STATUS_OK;
            $retVal[PAYLOAD] = $params;
        } else {
            $retVal[RESULT_CODE] = STATUS_OK;
            $retVal[PAYLOAD][MESSAGE_OK] = $params;
        }

        Response::response($retVal);
    }

    static function error($errorCode, $message = NULL)
    {
        $retVal = [];
        $retVal[RESULT_CODE] = STATUS_ERROR;
        $retVal[ERROR][ERROR_CODE] = (int)$errorCode;
        if (!is_null($message))
            $retVal[ERROR][MESSAGE_ERROR] = $message;

        Response::response($retVal);
    }
}