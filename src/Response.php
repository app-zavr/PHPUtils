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

function setResponse($data)
{
    if(! @PHPUNIT_RUNNING === 1 ) {
        header('Content-type: text/json');
        header('Content-type: application/json');
    }

    print_r(json_encode($data, TRUE));

//    if(! @PHPUNIT_RUNNING === 1 )
        exit;
}

function setOkResponse($params)
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

    setResponse($retVal);
}

function setErrorMessage($errorCode, $message = NULL)
{
    $retVal = [];
    $retVal[RESULT_CODE] = STATUS_ERROR;
    $retVal[ERROR][ERROR_CODE] = (int)$errorCode;
    if (!is_null($message))
        $retVal[ERROR][MESSAGE_ERROR] = $message;

    setResponse($retVal);
}

// TODO Прроверить на SQL инъекции и экранирование параметров
function getValueForParameter($value, $isString = true, $isNull = true, $checkKey = true)
{
    if ($checkKey) {
        if (!isset($_GET[$value])) {
            setErrorMessage(ERROR_REQUEST_NOT_ENOUGH_PARAMS);
        }
    }

    @$valueGet = $_GET[$value];

    if (empty($valueGet) && ($valueGet != 0)) {
        if (!$isNull)
            setErrorMessage(ERROR_REQUEST_NOT_NULL_VALUE);
    } else {
        if (!empty($valueGet) || ($valueGet == 0))
            return $valueGet;
    }

    return $isString ? '' : 0;
}