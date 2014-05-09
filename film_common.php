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
ini_set("memory_limit","1024M");
$db = new mysqli($global_config->db['hostname'], $global_config->db['username'], $global_config->db['password'], $global_config->db['database']);
$con_err = 0;
if ($db->errno) {
    $con_err = $db->errno;
}
if (! @$db->set_charset("utf8")) {
    $con_err = 'charset';
}
if ($con_err != 0) {
    errorPage('发生了一个错误：「数据库无法访问，' . $con_ok . '」，<br>望能将错误反馈至 <a href="mailto:sen@senorsen.com?subject=[film_db_bug]bug%20report_' . $con_ok .'&body=bug_id_' . $con_ok . '" target="_blank">sen@senorsen.com</a>，谢谢啦～～<br></body></html>');
}
$user_obj = null;
db_init();
function db_init() {
    global $db;
    $sql = array(
        "ALTER TABLE `poster_signup` ADD `processed` BOOLEAN NOT NULL DEFAULT FALSE AFTER `suffix2`, ADD INDEX (`processed`) ",
        "ALTER TABLE `poster_signup` ADD `user_obj` VARCHAR(255) NOT NULL ",
    );
    array_push($sql, file_get_contents('page_log.sql'));
    foreach ($sql as $value) {
        @$db->query($value);
    }
}
function view_handler($type, $file = null, $page_cfg = null, $callback = 'cb') {
    global $args, $db;
    $q_user_obj = $db->escape_string(json_encode(checkQSCToken()));
    $q_obj = $db->escape_string(json_encode($args));
    $q_ip = $db->escape_string(getip());
    $q_ajax = $db->escape_string($type);
    $q_page = $db->escape_string($file);
    $sql = "INSERT INTO page_log (page,ajax,success,user_obj,time,ip,obj) VALUES ('$q_page', '$q_ajax', 1, '$q_user_obj', NOW(), '$q_ip', '$q_obj') ";
    $db->query($sql);
    $view_obj = array();
    if ($type == 'json') {
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($page_cfg);
    } else if ($type == 'jsonp') {
        if (!preg_match('/^\w+$/', $callback)) {
            $callback = 'cb';
        }
        header("Content-Type: application/javascript; charset=utf-8");
        echo $callback;
        echo '(' . json_encode($page_Cfg) . ');';
    } else if ($type === FALSE) {
        // header("Content-Type: text/html; charset=utf-8");
        // refers to 'html' view
        $view_obj['global_cfg'] = buildGlobalConfig();
        if (is_null($page_cfg)) {
            $view_obj['page_cfg'] = array();
        } else {
            $view_obj['page_cfg'] = $page_cfg;
        }
        $view_obj = (object)$view_obj;
        $path = 'view/' . $file . '.php';
        if (!file_exists($path)) {
            //errorPage('似乎并木有这只视图喵～');
            return;
        }
        include $path;
    }
}
function buildGlobalConfig() {
    $userobj = checkQSCToken();
    if (!$userobj) {
        $userobj = 0;
    } else {
        unset($userobj->password);
    }
    $global_cfg = array(
        'random_token' => getToken(),
        'userobj' => $userobj,
    );
    return $global_cfg;
}
function checkQSCToken($token = null) {
    global $user_obj;
    if (!is_null($user_obj)) {
        return $user_obj;
    }
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
        return $user_obj = FALSE;
    } else {
        if (isset($retobj->code) && $retobj->code == 0) {
            return $user_obj = FALSE;
        } else {
            $user_obj = $retobj;
            return $retobj;
        }
    }
}       
function curlFetch($url, $data = null, $timeout = 5) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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
function customError($errno, $errstr, $errfile, $errline) {
    $str = '';
    $str .= "噗，<b>出错啦:</b> [$errno] $errstr<br />";
    $str .= " Line $errline in $errfile<br />";
    errorPage($str);
}
function errorPage($content, $e = null, $title = '=_= 出错了') {
    global $args, $action, $db, $ajax;
    if (is_null($e)) {
        $e = new Exception;
    }
    if (!is_null($e)) {
        $es = $e->getTraceAsString();
        $es = explode("\n", $es);
        $e0 = $es[1];
    } else {
        $e0 = 'unknown_bug';
    }
    $q_obj = $db->escape_string(json_encode($args));
    $q_page = $db->escape_string($action);
    $q_ajax = $db->escape_string($ajax);
    $q_user_obj = $db->escape_string(json_encode(checkQSCToken));
    $q_ip = $db->escape_string(getip());
    $sql = "INSERT INTO page_log (page,success,user_obj,time,ip,obj,ajax) VALUES ('$q_page', 0, '$q_user_obj', NOW(), '$q_ip', '$q_obj', '$q_ajax') ";
    $db->query($sql);
    echo '<!doctype html>
        <html><head><meta charset="utf-8"><title>' . htmlspecialchars($title) . '</title></head><body>
        ' . $content . '<br>欢迎报告错误：E-mail: <a href="mailto:sen@senorsen.com?subject=[film_dub_bug_report]bug_report&body=' . htmlspecialchars($e0) . '" target="_blank">sen@senorsen.com</a><br><br><a href="./">点击此处返回首页</a><br>';
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
    $ret = $e->getTraceAsString();
    $retarr = explode("\n", $ret);
    foreach ($retarr as &$value) {
        if (preg_match('/password/', $value)) {
            $value = '#n database settings will not be displayed.';
        }
        $value = htmlspecialchars($value);
    }
    $ret = implode("\n", $retarr);
    if ($nl2br) {
        $ret = nl2br($ret);
    }
    if ($ret_to_var) {
        return $ret;
    } else {
        echo $ret;
    }
}
function isunknown($type) {
    if (!in_array(intval($type), array(1, 2, 3, 6))) {
        return TRUE;
    } else {
        return FALSE;
    }
}
function get($key) {
    global $args;
    if (isset($args[$key])) {
        return $args[$key];
    } else {
        return null;
    }
}
function judgeifmod($file) {
    $lastmodtime = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : '';
    if ($lastmodtime == '') {
        $lastmodtime = 0;
    } else {
        $lastmodtime = strtotime($lastmodtime);
    }
    if (!file_exists($file)) {
        return TRUE;
    }
    $filemtime = filemtime($file);
    if ($lastmodtime < $filemtime) {
        $maxage = 3600 * 24 * 30;
        $expire = strftime("%a, %d %b %G %H:%M:%S GMT+8", time() + $maxage);
        header("Cache-Control: max-age=$maxage");
        $lastmodify = strftime("%a, %d %b %G %H:%M:%S GMT+8", $filemtime);
        header("Last-Modified: $lastmodify");
        return TRUE;
    } else {
        $lastmodify = strftime("%a, %d %b %G %H:%M:%S GMT+8", $filemtime);
        header("Last-Modified: $lastmodify");
        header("HTTP/1.1 304 Not Modified");
        return FALSE;
    }
}
function getdir($path) {
    $handler = opendir('./');
    $fds = array();
    $filename = readdir($handler);
    while ($filename !== false) {
        if (preg_match('/^(.+?)\.php$/', $filename, $matches)) {
            array_push($fds, $matches[1]);
        }
        $filename = readdir($handler);
    }
    closedir($handler);
    return $fds;
}
