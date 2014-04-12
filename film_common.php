<?php
/**
 * common function definitions module of film_dub project.
 *
 * @version none
 * @author Senorsen <sen@senorsen.com>
 % @description as is
 * @description 2014-04-13 Sun 02:14:32 EST
 * @link http://pub.qsc.senorsen.com/dub/
 *
 */

if (!defined('SEN_DIR')) die('No direct script access. Senorsen.');
date_default_timezone_set('PRC');
$db = new mysqli($global_config['hostname'], $global_config['username'], $global_config['password'], $global_config['database']);
$con_err = 0;
if ($db->errno) {
    $con_ok = $db->errno;
}
if (! @$db->set_charset("utf-8")) {
    $con_ok = 'charset';
}
if ($con_ok != 0) {
    errorPage('发生了一个错误：「数据库无法访问，' . $con_ok . '」，<br>望能将错误反馈至 <a href="mailto:sen@senorsen.com?subject=[film_db_bug]bug%20report_' . $con_ok .'&body=bug_id_' . $con_ok . '" target="_blank">sen@senorsen.com</a>，谢谢啦～～<br></body></html>');
}
function view_handler($type, $file = null, $view_obj = null, $callback = 'cb') {
    if ($type == 'json') {
        echo json_encode($view_obj);
    } else if ($type == 'jsonp') {
        if (!preg_match('/^\w+$/', $callback)) {
            $callback = 'cb';
        }
        echo $callback;
        echo '(' . json_encode($view_obj) . ');';
    } else if ($type === FALSE) {
        // refers to 'html' view
        include 'view/' . $file . '.php';
    }    
}
function errorPage($content, $e = null, $title = '=_= 出错了') {
    if (!is_null($e)) {
        $es = $e->getTraceAsString();
        $e0 = $es[0];
    } else {
        $e0 = 'unknown_bug';
    }
    echo '<!doctype html>
        <html><head><meta charset="utf-8"><title>' . htmlspecialchars($title) . '</title></head><body>
        ' . $content . '<br>欢迎报告错误：E-mail: <a href="mailto:sen@senorsen.com?subject=[film_dub_bug_report]bug_report&body=' . htmlspecialchars($e0) . '" target="_blank">sen@senorsen.com</a><br>';
    if (!is_null($e)) {
        echo 'Trace 喵 log =v=: <br>';
        getTrace($e);
    }
    echo '</body></html>';
    // 出错了，那么就结束这一切吧。
    exit;
}
function genToken() {
    if (!isset($COOKIE['film_dub_token_gen'])) {
        setcookie('film_dub_token_gen', randomString(10), time() + 3600 * 24), '/');
    }
}
function checkToken() {
    if (isset($_COOKIE['film_dub_token_gen'] && isset($_REQUEST['random_token'])) {
        if (md5('film_dub_token_senorsen' . $_COOKIE['film_dub_token_gen']) == $_REQUEST['random_token']) {
            // give us a brand new token
            genToken();
            return TRUE;
        } else {
            return FALSE;
        }
    } else {
        // 只有当ajax时才检查，ajax下无token，一定是坏蛋。
        return FALSE;
    }
}
function getip() {
    return $_SERVER['REMOTE_ADDR'];
}
function randomString($num = 10) {
    $char_list = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $str = '';
    while ($num--) {
        $str .= $char_list[rand(0, strlen($char_list) - 1)];
    }
    return $str;
}
function getTrace($e, $ret_to_var = FALSE, $nl2br == TRUE) {
    if ($ret_to_var || $nl2br) {
        ob_start();
    }
    var_dump($e->getTraceAsString());
    if ($ret_to_var || $nl2br) {
        $ret = ob_get_clean();
        if (!$ret_to_var) {
            // $nl2br here must be TRUE.
            echo nl2br($ret);
        } else {
            if ($nl2br) {
                $ret = nl2br($ret);
            }
            return $ret;
        }
    }
}

