<?php
/**
 *
 * main functional area of Senorsen's code of film_dub.
 * @author Senorsen
 * 
 */
define('SEN_DIR', __DIR__);
require "film_config.php";
require "film_common.php";
require "dispatch.php";
set_error_handler("customError");
try {
/*
  main block
*/
    $actions = array(
        'ajax' => array(
            'submit_signup',
            'submit_poster'
        ),
        'common' => array('', 
            'setQSCToken',
            'goLogin',
            'main',
            'dub',
            'forum',
            'show',
            'poster'
        ),
        'ajax_type' => array(
            'json',
            'jsonp',
            'pjax'
        )
    );
    if (!isset($callback)) {
        $callback = 'callback';
    }
    if (!defined('SEN_SHELL')) {
        if (isset($_GET['q'])) {
            // q存在时将覆盖在action的♂上边。
            $_REQUEST['action'] = $_GET['q'];
        }
        if (isset($_REQUEST['ajax']) && is_string($_REQUEST['ajax'])) {
            if (!checkToken() || !in_array($_REQUEST['ajax'], $actions['ajax_type'])) {
                errorPage('奇怪的错误，不知道是为什么，想报告给我嘛？～');
            } else {
                $ajax = $_REQUEST['ajax'];
            }
        } else {
            $ajax = FALSE;
        }
        if (isset($_REQUEST['action']) && is_string($_REQUEST['action'])) {
            if ($ajax === FALSE) {
                if (!in_array($_REQUEST['action'], $actions['common'])) {
                    header("HTTP/1.1 404 Not Found");
                    errorPage('噗，这个页面并没有被定义。<br>如果您认为这是个错误，欢迎向我来报告哟～～');
                } else {
                    $action = $_REQUEST['action'];
                }
            } else {
                if (!in_array($_REQUEST['action'], $actions['ajax'])) {
                    header("HTTP/1.1 404 Not Found");
                    errorPage("ajax_action未找到。。。困死了");
                } else {
                    $action = $_REQUEST['action'];
                    if (isset($_REQUEST['callback']) && is_string($_REQUEST['callback'])) {
                        $callback = $_REQUEST['callback'];
                    }
                }
            }
        } else {
            if ($ajax != FALSE) {
                errorPage('好像有点小错误吧。。。。噗。。。天哪噜。。。');
            } else {
                $action = 'main';
            }
        }
        $args = $_REQUEST;
        unset($args['ajax']);
        unset($args['action']);
        unset($args['random_token']);
        unset($args['callback']);
    }
    $dispatch = new Dispatch($args, $db, $global_config);
    $ret = null;
    if (method_exists($dispatch, $action)) {
        // the saf
        eval('$ret = $dispatch->' . $action . '($args);');
    }
    if ($action == '') {
        $action = 'main';
    }
    view_handler($ajax, $action, (object)$ret, $callback);
    // happy ending.
    
} catch (Exception $e) {
    errorPage('index.php 出现错误啦！ =_= 噗。。。<br>', $e);
    // 本来想记录错误到数据库的，不过想想还是算了吧。
}

