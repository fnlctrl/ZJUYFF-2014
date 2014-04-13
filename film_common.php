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
$db = new mysqli($global_config->db['hostname'], $global_config->db['username'], $global_config->db['password'], $global_config->db['database']);
$con_err = 0;
if ($db->errno) {
    $con_err = $db->errno;
}
if (! @$db->set_charset("utf8")) {
    $con_err = 'charset';
}
if ($con_err != 0) {
    errorPage('发生了一个错误：「数据库无法访问，' . $con_ok . '」，<br>望能将错误反馈至 <a href="mailto:sen@senorsen.com?subject=[film_db_bug]bug%20report_' . $con_ok .'&body=bug_id_' . $con_ok . '" target="_blank">sen@senorsen.com</a>，谢谢啦～～<br><br><a href="./">点击此处返回首页</a></body></html>');
}
function view_handler($type, $file = null, $view_obj = null, $callback = 'cb') {
    $view_obj = (object)$view_obj;
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
        $view_obj->global_cfg = array(
            'random_token' => getToken()
        );
        if (!isset($view_obj->page_cfg)) {
            $view_obj->page_cfg = array();
        }
        $path = 'view/' . $file . '.php';
        if (!file_exists($path)) {
            //errorPage('似乎并木有这只视图喵～');
            return;
        }
        include $path;
    }    
}
function checkQSCToken($token = null) {
    $check_url = 'http://passport.myqsc.com/api/get_member_by_token?token=';
    if (is_null($token)) {
        if (isset($_COOKIE['qsctoken'])) {
            $token = $_COOKIE['qsctoken'];
        } else {
            return FALSE;
        }
    }
    $check_url .= $token;
    $retstr = curlFetch($check_url);
    $retobj = json_decode($retstr);
    if (is_null($retobj)) {
        return FALSE;
    } else {
        if (isset($retobj->code) && $retobj->code == 0) {
            return FALSE;
        } else {
            return $retobj;
        }
    }
}       
function curlFetch($url, $data = null, $timeout = 5) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    if (!is_null($data)) {
        if (is_string($data)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFILEDS, $data);
        } else {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
    }
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    $str = curl_exec($ch);
    curl_close($ch);
    return $str;
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
function genToken($rogue = FALSE) {
    if ($rogue || !isset($_COOKIE['film_dub_token_gen'])) {
        $rndstr = randomString(10);
        setcookie('film_dub_token_gen', $rndstr, time() + 3600 * 24, '/');
        return $rndstr;
    } else {
        return $_COOKIE['film_dub_token_gen'];
    }
}
function getToken() {
    $rndstr = genToken(FALSE);
    return md5('film_dub_token_senorsen' . $rndstr);
}
function checkToken() {
    if (isset($_COOKIE['film_dub_token_gen']) && isset($_REQUEST['random_token'])) {
        if (getToken() == $_REQUEST['random_token']) {
            // give us a brand new token
            //genToken(TRUE);
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
function getTrace($e, $ret_to_var = FALSE, $nl2br = TRUE) {
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

