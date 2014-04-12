<?php
/**
 * controller dispatcher & model module of film_dub project.
 *
 * @version none
 * @author Senorsen <sen@senorsen.com>
 % @description as is
 * @description 2014-04-13 Sun 03:18:20 EST
 * @link http://pub.qsc.senorsen.com/dub/
 *
 */

if (!defined('SEN_DIR')) die('No direct script access. Senorsen.');

class Dispatch {
    private $db;
    private $args;
    function __construct($args, $db) {
        $this->args = $args;
    }
    function index() {
        return null;
    }
    function submit_signup() {
        $methods = array('online', 'live');
        $requires = array(
            'team-name' => 'team_name',
            'team-slogan' => 'slogan',
            'name-captain' => 'name1',
            'mobile-captain' => 'phone1',
            'email-captain' => 'email1',
            'name-teammate1' => 'name2',
            'mobile-teammate1' => 'phone2',
            'email-teammate1' => 'email2',
            'name-teammate2' => 'name3',
            'mobile-teammate2' => 'phone3',
            'email-teammate2' => 'email3',
            'name-teammate3' => 'name4',
            'mobile-teammate3' => 'phone4',
            'email-teammate3' => 'email4',
            'name-teammate4' => 'name5',
            'mobile-teammate4' => 'phone5',
            'email-teammate4' => 'email5',
            'name-teammate5' => 'name6',
            'mobile-teammate5' => 'phone6',
            'email-teammate5' => 'email6',
            'name-teammate6' => 'name7',
            'mobile-teammate6' => 'phone7',
            'email-teammate6' => 'email7',
            'method' => 'method'
        );
        $req_no_empty = array(
            'team_name' => '噗，队伍名字是要填的哦～',
            'slogan' => '团队口号必须有哦～',
            'name1' => '至少要有一名队长带队哦 =v=',
            'phone1' => '队长的手机确实是必填的呢！～',
            'email1' => '噗，队长的邮箱也必须填写哦=_='
        );
        $newobj = array();
        // 不允许post数组上来！
        foreach ($args as $value) {
            if (is_array($value)) {
                errorPage('噗，居然传来了一个数组……吓死人啦！！');
            }
        }
        foreach ($requires as &$key => &$value) {
            if (!in_array($value, $args)) {
                return array('code' => 1, 'msg' => '操作失败：关键表单项未找到');
            } else {
                $newobj[$key] = $args[$value];
                if (isset($req_no_empty[$key]) && $newobj[$key] == '') {
                    return array('code' => 2, 'msg' => $req_no_empty[$key]);
                }
            }
        }
        foreach ($newobj as $key => $value) {
            if (preg_match('/^phone/', $key)) {
                if (!preg_match('/^\d*$/', $value)) {
                    return array('code' => 3, 'msg' => '手机号码必须为数字哦');
                }
            }
            if (preg_match('/^email/', $key)) {
                if ($value != '' && !preg_match('/^.+@.+\..+/', $value)) {
                    return array('code' => 3, 'msg' => '邮箱格式好像错了哦～');
                }
            }
        }
        
