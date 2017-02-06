<?php
/**
 * Created by PhpStorm.
 * User: temasnow
 * Date: 06.02.17
 * Time: 17:41
 */

namespace Appzavr\PHPUtils;

define('ERROR_SQL_EXEC', -200);

class SQL
{
    const ERROR_SQL_CONNECT = 'SQL error while connecting';
    const ERROR_SQL_EXEC = 'SQL error execution';

    private static $link;

    public static function connect($credentials)
    {
        self::$link = mysqli_connect($credentials['host'], $credentials['user'], $credentials['password']) or setErrorMessage(self::ERROR_SQL_CONNECT, [
            'mysql_error' => mysqli_error(self::$link),
            'trace' => __METHOD__ . "::" . __LINE__
        ]);
        mysqli_set_charset(self::$link, 'utf8mb4');
    }

    public static function disconnect()
    {
        mysqli_close(self::$link);
    }

    static function executeSQLwithReturn($credentials, $query, $isSingle = FALSE, $sql_visible_fields = NULL)
    {
        self::connect($credentials);

        if ($isSingle) {
            $row = $sql_visible_fields;

            $result = mysqli_query(self::$link, $query) or setErrorMessage(self::ERROR_SQL_EXEC,
                [
                    mysqli_error(self::$link),
                    $query
                ]);
            if (!$result)
                setErrorMessage(self::ERROR_SQL_EXEC,
                    [
                        mysqli_error(self::$link),
                        $query
                    ]);

            $retParse = '';
            while ($line = mysqli_fetch_object($result))
                $retParse = $line->$row;

            mysqli_free_result($result);

            self::disconnect();

            return $retParse;
        } else {

            $result = mysqli_query(self::$link, $query) or setErrorMessage(self::ERROR_SQL_EXEC,
                [
                    mysqli_error(self::$link),
                    $query
                ]);
            if (!$result)
                setErrorMessage(self::ERROR_SQL_EXEC,
                    [
                        mysqli_error(self::$link),
                        $query
                    ]);

            $retParse = array();
            $indexParse = 0;
            while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                //Если нет конкретных указаний, показываем все поля
                if ($sql_visible_fields == NULL)
                    foreach ($line as $key => $value)
                        $retParse[$indexParse][$key] = $value;
                else
                    foreach ($sql_visible_fields as $key)
                        $retParse[$indexParse][$key] = $line[$key];

                $indexParse++;
            }

            mysqli_free_result($result);

            self::disconnect();

            return $retParse;
        }
    }

    static function executeSQLBindWithReturn($credentials, $query, $types, $params, $isSingle = FALSE, $sql_visible_fields = NULL)
    {
        self::connect($credentials);

        $stm = mysqli_prepare(self::$link, $query);

        call_user_func_array([$stm, "bind_param"], array_merge($types, $params));
        $stm->execute();

        $result = $stm->result_metadata();
        if ($isSingle) {
            $row = $sql_visible_fields;

            if (!$result)
                setErrorMessage(self::ERROR_SQL_EXEC,
                    [
                        mysqli_error(self::$link),
                        $query
                    ]);

            $retParse = '';
            while ($line = mysqli_fetch_object($result))
                $retParse = $line->$row;

            mysqli_free_result($result);

            self::disconnect();

            return $retParse;
        } else {
            if (!$result)
                setErrorMessage(self::ERROR_SQL_EXEC,
                    [
                        mysqli_error(self::$link),
                        $query
                    ]);

            $retParse = array();
            $indexParse = 0;
            while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
                //Если нет конкретных указаний, показываем все поля
                if ($sql_visible_fields == NULL)
                    foreach ($line as $key => $value)
                        $retParse[$indexParse][$key] = $value;
                else
                    foreach ($sql_visible_fields as $key)
                        $retParse[$indexParse][$key] = $line[$key];

                $indexParse++;
            }

            mysqli_free_result($result);

            self::disconnect();

            return $retParse;
        }
    }

    static function executeSQL($credentials, $query, $showError = TRUE, $exception = false)
    {
        self::connect($credentials);

        if ($showError)
            mysqli_query(self::$link,$query) or setErrorMessage(ERROR_SQL_EXEC,
                [
                    mysqli_error(self::$link),
                    $query
                ]
                , $exception);
        else
            mysqli_query(self::$link, $query);

        self::disconnect();
    }

    static function executeSQLBind($credentials, $query, $strParam)
    {
        self::connect($credentials);

        $stm = mysqli_prepare(self::$link, $query);

        $stm->bind_param('s', $strParam);
        $stm->execute();

        self::disconnect();
    }

    static function executeSQLmulti($credentials, $query, $showError = TRUE)
    {
        self::connect($credentials);

        if ($showError) {
            mysqli_multi_query(self::$link, $query) or setErrorMessage(ERROR_SQL_EXEC,
                [
                    mysqli_error(self::$link),
                    $query
                ]);
        }
        else
            mysqli_multi_query(self::$link, $query);

        self::disconnect();
    }
}
