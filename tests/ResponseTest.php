<?php
/**
 * Created by PhpStorm.
 * User: temasnow
 * Date: 27.12.16
 * Time: 0:58
 */

namespace Appzavr\PHPUtils;

define('PHPUNIT_RUNNING', 1);

require_once __DIR__.'/../src/Response.php';

class ResponseTest extends \PHPUnit_Framework_TestCase
{

    public function testErrorResponse()
    {
        $retVal = [
            RESULT_CODE => STATUS_ERROR,
            ERROR => [
                ERROR_CODE => 1,
                MESSAGE_ERROR => 'Error message'
            ]
        ];

        $this->expectOutputString(json_encode($retVal));
        setErrorMessage(1, 'Error message');
    }

    public function testOkResponse()
    {
        $retVal = [
            RESULT_CODE => STATUS_OK,
            PAYLOAD => [
                'test' => true
            ]
        ];

        $this->expectOutputString(json_encode($retVal));
        setOkResponse(['test' => true]);
    }
}
