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
        $this->db = $db;
    }
    function index($args) {
        return null;
    }
    function submit_signup($args) {
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
        foreach ($requires as $key => &$value) {
            if (!isset($args[$key])) {
                return array('code' => 1, 'msg' => '关键表单项未找到');
            } else {
                $newobj[$value] = $args[$key];
                if (isset($req_no_empty[$key]) && $newobj[$key] == '') {
                    return array('code' => 2, 'msg' => $req_no_empty[$key]);
                }
            }
        }
        if (!in_array($newobj['method'], $methods)) {
            return array('code' => 3, 'msg' => '噗，参赛方式好像错误了，如果你确定你没选错，请联系 sen@senorsen.com ~打搅啦');
        }
        $members = 0;
        $member_list = array();
        $phone_list = array();
        $email_list = array();
        foreach ($newobj as $key => &$value) {
            $value = $this->db->escape_string($value);
            $$key = $value;
            if (preg_match('/^phone/', $key)) {
                if (!preg_match('/^\d*$/', $value)) {
                    return array('code' => 3, 'msg' => '手机号码必须为数字哦');
                } else {
                    $match = preg_replace('/^phone(\d+)$/', '$1', $key);
                    $phone_list['name' . $match] = $value;
                }
            }
            if (preg_match('/^email/', $key)) {
                if ($value != '' && !preg_match('/^.+@.+\..+/', $value)) {
                    return array('code' => 3, 'msg' => '邮箱格式好像错了哦～');
                } else {
                    $match = preg_replace('/^email(\d+)$/', '$1', $key);
                    $email_list['name' . $match] = $value;
                }
            }
            if (preg_match('/^name/', $key) && $value != '') {
                $members++;
                array_push($member_list, array(
                    'leader' => $key == 'name1' ? 1 : 0,
                    'name' => $value,
                    'name_key' => $key
                ));
            }
        }
        foreach ($member_list as &$value) {
            $value['phone'] = $phone_list[$value['name_key']];
            $value['email'] = $email_list[$value['name_key']];
            unset($value['name_key']);
        }
        $r_ip = $this->db->escape_string(getIP());
        $sql = "INSERT INTO dub_team (team_name, slogan, method, members, time, ip) VALUES ('$team_name', '$slogan', '$method', '$members', NOW(), '$r_ip') ";
        $this->db->query($sql);
        if ($this->db->errno) {
            return array('code' => 100, 'msg' => '噗，数据库插入_team_操作出错！太可怕啦，请联系我～～ sen@senorsen.com');
        }
        $tid = $this->db->insert_id;
        foreach ($member_list as &$value) {
            $sql = "INSERT INTO dub_teammate (tid, name, leader, phone, email) VALUES ($tid, '$value->name', $value->leader, '$value->phone', '$value->email') ";
            $this->db->query($sql);
            if ($this->db->errno) {
                return array('code' => 100, 'msg' => '噗，数据库插入_teammate_操作出错！太可怕啦，请联系我～～ sen@senorsen.com');
            }
        }
        return array('code' => 0, 'msg' => '提交成功');
    }
}
