<?php
define('SEN_DIR', __DIR__);
try {
/*
  main block
*/
    $actions = array(
        'ajax' => array(
            'submit_signup',
            'submit_vote'
        ),
        'common' => array('', 
            'index'
        ),
        'ajax_type' => array(
            'json',
            'jsonp',
            'pjax'
    );
    if (!defined('SEN_SHELL')) {
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
                    errorPage('噗，这个页面并没有被定义。<br>如果您认为这是个错误，欢迎向我来报告哟～～');
                } else {
                    $action = $_REQUEST['action'];
                }
            }
        } else {
            if ($ajax != FALSE) {
                errorPage('好像有点小错误吧。。。。噗。。。天哪噜。。。');
            }
        }
    }

} catch (Exception $e) {
    errorPage('index.php 出现错误啦！=v=', $e);
    // 本来想记录错误到数据库的，不过想想还是算了吧。
}

