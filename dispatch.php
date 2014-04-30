<?php
/**
 * controller dispatcher & model module of film_dub project.
 *
 * @version none
 * @author Senorsen <sen@senorsen.com>
 * @description as is
 * @description 2014-04-13 Sun 03:18:20 EST
 * @link http://pub.qsc.senorsen.com/dub/
 *
 */

if (!defined('SEN_DIR')) die('No direct script access. Senorsen.');

class Dispatch {
    private $db, $bcfg;
    private $args;
    private $upload_dir;
    function __construct($args, $db, $bcfg) {
        global $global_config;
        $this->args = $args;
        $this->db = $db;
        $this->bcfg = $bcfg;
        $this->upload_dir = $global_config->upload_dir;
    }
    public function setQSCToken($args) {
        if (isset($args['token']) && is_string($args['token'])) {
            $ret = checkQSCToken($args['token']);
            if ($ret != FALSE) {
                setcookie('qsctoken', $args['token'], time() + 3600 * 24 * 30, '/', 'myqsc.com');
                header('Location: ./'.$args['senredir']);
            } else {
                errorPage('错误：登录失败～');
            }
        } else {
            errorPage('错误：根本没有登录信息噗');
        }
    }
    public function goLogin($args) {
        $my_url = $this->bcfg->my_url_wrap . 'setQSCToken';
        // 临时地址
        $passport_login_dir = 'https://passport.myqsc.com/member/auth?redirect=';
        if (isset($args['redir']) && !is_string($args['redir'])) {
            errorPage('错误：redir参数有误哦～');
        }
        $redir = '';
        if (isset($args['redir'])) {
            $redir = $args['redir'];
        }
        $go_url = $passport_login_dir . urlencode($my_url . '?senredir=' . $redir);
        header('Location: ' . $go_url);
    }
    public function myadmin($args) {
        if (!isset($args['view'])) {
            $args['view'] = 'dub';
        }
        if (isset($args['view']) && is_string($args['view'])) {
           $view = $args['view'];
        } else {
            errorPage('错误：view未指定或错误');
        }
        $wl_view = array('dub', 'poster');
        if (!in_array($view, $wl_view)) {
            errorPage('view未定义');
        }
        if (isset($_SERVER['PHP_AUTH_USER'])) {
            $user = $_SERVER['PHP_AUTH_USER'];
            $pwd = $_SERVER['PHP_AUTH_PW'];
            if ($user == 'zjuff' && $pwd == 'MjAxNMTqIDA0') {
            
            } else {
                header('WWW-Authenticate: Basic realm="Hey hey hey pu"');
                header('HTTP/1.1 401 Unauthorized');
                errorPage('噗，看看吧。');
            }
        } else {
            header('WWW-Authenticate: Basic realm="Hey hey hey pu"');
            header('HTTP/1.1 401 Unauthorized');
            errorPage('噗，看看吧。');
        }
        $retarr = $this->{$view . 'Admin'}();
        foreach ($retarr as &$value) {
            foreach ($value as &$vvalue) {
                if (is_string($vvalue)) {
                    $vvalue = htmlspecialchars($vvalue);
                } else if (is_array($vvalue) && is_object($vvalue)) {
                    foreach ($vvalue as &$vvvalue) {
                        $vvvalue = htmlspecialchars($vvvalue);
                    }
                }
            }
        }
        return (object)array(
            'view' => $view,
            'retarr' => $retarr
        );
    }
    private function dubAdmin() {
        $sql = "SELECT * FROM dub_team ";
        $result = $this->db->query($sql);
        $rows = array();
        while ($row = $result->fetch_object()) {
            $dub_rows = array();
            $dub_sql = "SELECT * FROM dub_teammate WHERE tid=" . $row->id;
            $dub_result = $this->db->query($dub_sql);
            while ($dub_row = $dub_result->fetch_object()) {
                array_push($dub_rows, $dub_row);
            }
            $row->teammate = $dub_rows;
            array_push($rows, $row);
        }
        return $rows;
    }
    private function posterAdmin() {
        $sql = "SELECT * FROM poster_signup ";
        $result = $this->db->query($sql);
        $rows = array();
        while ($row = $result->fetch_object()) {
            $dub_rows = array();
            $dub_sql = "SELECT * FROM poster_member WHERE sid=" . $row->id;
            $dub_result = $this->db->query($dub_sql);
            while ($dub_row = $dub_result->fetch_object()) {
                array_push($dub_rows, $dub_row);
            }
            $row->teammate = $dub_rows;
            array_push($rows, $row);
        }
        return $rows;
    }
    public function poster($args) {
        $sql = "SELECT id,name,members,time FROM poster_signup ";
        $result = $this->db->query($sql);
        $s_rows = array();
        $id2vid = array();
        while ($s_row = $result->fetch_object()) {
            $s_row->m = array();
            $sql = "SELECT id,sid,name,leader FROM poster_member WHERE sid=$s_row->id ";
            $m_res = $this->db->query($sql);
            while ($m_row = $m_res->fetch_object()) {
                array_push($s_row->m, $m_row);
            }
            array_push($s_rows, $s_row);
        }
        return array('page_cfg' => array('poster' => $s_rows));
    }
    public function get_intro($args) {
        if (!isset($args['id'])) {
            return array('code' => 1, 'msg' => '未提供id');
        }
        $id = intval($args['id']);
        $sql = "SELECT id,introduction FROM poster_signup WHERE id=$id";
        $result = $this->db->query($sql);
        if (!$result) {
            return array('code' => 100, 'msg' => '查询时错误');
        }
        $row = $result->fetch_object();
        if (!$row) {
            return array('code' => 100, 'msg' => '查询集 == 0');
        }
        return array('code' => 0, 'msg' => 'ERR_SUCCESS', 'obj' => $row);
    }
    public function submit_signup($args) {
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
        $r_ip = $this->db->escape_string(getip());
        $sql = "INSERT INTO dub_team (team_name, slogan, method, members, time, ip) VALUES ('$team_name', '$slogan', '$method', '$members', NOW(), '$r_ip') ";
        $this->db->query($sql);
        if ($this->db->errno) {
            return array('code' => 100, 'msg' => '噗，数据库插入_team_操作出错！太可怕啦，请联系我～～ sen@senorsen.com');
        }
        $tid = $this->db->insert_id;
        foreach ($member_list as &$value) {
            $value = (object)$value;
            $sql = "INSERT INTO dub_teammate (tid, name, leader, phone, email) VALUES ($tid, '$value->name', $value->leader, '$value->phone', '$value->email') ";
            $this->db->query($sql);
            if ($this->db->errno) {
                return array('code' => 100, 'msg' => '噗，数据库插入_teammate_操作出错！太可怕啦，请联系我～～ sen@senorsen.com');
            }
        }
        return array('code' => 0, 'msg' => '提交成功');
    }
    public function submit_poster($args) {
        $length_limit = 3 * 1024 * 1024; 
        if (!isset($_FILES['img1']) || !isset($_FILES['img2'])) {
            return array('code' => 1, 'msg' => '噗，参赛作品和原版海报都要上传的哦～');
        }
        if (is_uploaded_file($_FILES['img1']['tmp_name']) && is_uploaded_file($_FILES['img2']['tmp_name'])) {
            if ($_FILES['img1']['size'] > $length_limit) {
                return array('code' => 1, 'msg' => '参赛作品大小超过限制了哦～请压缩后重新上传');
            }
            if ($_FILES['img2']['size'] > $length_limit) {
                return array('code' => 1, 'msg' => '原版海报大小超过限制了哦～请压缩后重新上传');
            }
        } else {
            return array('code' => 1, 'msg' => '噗，参赛作品和原版海报都要上传的哟～');
        }
        $requires = array(
            'name' => '电影名称',
            'name1' => '队长姓名',
            'stuid1' => '队长学号',
            'contact1' => '队长联系方式',
            'introduction' => '作品介绍'
        );
        foreach ($args as $value) {
            if (is_array($value)) {
                errorPage('错误：本页面真·不能接受数组的。。');
            }
        }
        foreach ($requires as $key => $value) {
            if (!isset($args[$key])) {
                return array('code' => 1, 'msg' => $value . '是必填的哟=v=');
            }
        }
        $all = array('name', 'introduction');
        for ($i = 1; $i <= 7; $i++) {
            array_push($all, 'name' . $i);
            array_push($all, 'stuid' . $i);
            array_push($all, 'contact' . $i);
        }
        $newobj = array();
        foreach ($all as $value) {
            if (isset($args[$value]) && $args[$value] != '') {
                $newobj[$value] = $this->db->escape_string($args[$value]);
            }
        }
        $members = array();
        $cnt_members = 0;
        foreach ($newobj as $key => &$value) {
            if (preg_match('/^name(\d+)$/', $key)) {
                $this_id = preg_replace('/^name(\d+)$/', '$1', $key);
                if (!isset($newobj['stuid' . $this_id]) || !isset($newobj['contact' . $this_id])) {
                    return array('code' => 1, 'msg' => '队员的信息是必填的哟～');
                } else {
                    $cnt_members++;
                    array_push($members, array('name' => $value, 'stuid' => $newobj['stuid' . $this_id], 'contact' => $newobj['contact' . $this_id], 'leader' => $key == 'name1' ? 1 : 0));
                }
            }
            $$key = $value;
        }
        $ip = $this->db->escape_string(getip());
        if (function_exists('exif_imagetype')) {
            $pictype1 = @exif_imagetype($_FILES['img1']['tmp_name']);
            $pictype2 = @exif_imagetype($_FILES['img2']['tmp_name']);
        } else {
            // 未知
            $pictype1 = 0;
            $pictype2 = 0;
        }
        $sql = "INSERT INTO poster_signup (name, members, pictype1, pictype2, introduction, time, ip) VALUES ('$name', $cnt_members, $pictype1, $pictype2, '$introduction', NOW(), '$ip') ";
        $this->db->query($sql);
        if ($this->db->errno) {
            return array('code' => 100, 'msg' => '处理poster_signup时遇到数据库插入错误，非常抱歉！请联系 sen@senorsen.com，谢谢啦～');
        }
        $sid = $this->db->insert_id;
        // 晚上或明天我会添加 各种图片，包括bmp，转jpg功能。
        move_uploaded_file($_FILES['img1']['tmp_name'], $this->upload_dir . 'img1_' . $sid . '.jpg');
        move_uploaded_file($_FILES['img2']['tmp_name'], $this->upload_dir . 'img2_' . $sid . '.jpg');
        foreach ($members as $value) {
            $value = (object)$value;
            $sql = "INSERT INTO poster_member (sid, name, leader, stuid, contact) VALUES ($sid, '$value->name', $value->leader, '$value->stuid', '$value->contact') ";
            $this->db->query($sql);
            if ($this->db->errno) {
                return array('code' => 100, 'msg' => '处理poster_member时遇到数据库插入错误，非常抱歉！请联系 sen@senorsen.com，谢谢啦～');
            }
        }
        return array('code' => 0, 'sid' => $sid, 'msg' => '报名成功，感谢参与～');
    }        
    public function posterParse() {
        $sql = "SELECT * FROM poster_signup WHERE pictype1=0 or pictype2=0 ";
        $result = $this->db->query($sql);
        while ($row = $result->fetch_object()) {
            echo "ID=$row->id $row->name ";
            // =v= 再重复一遍： 晚上或明天我会添加各种图片，包括bmp，转jpg功能。
            $pictype1 = exif_imagetype($this->upload_dir . 'img1_' . $row->id . '.jpg');
            $pictype2 = exif_imagetype($this->upload_dir . 'img2_' . $row->id . '.jpg');
            echo "pictype1=$pictype1, pictype2=$pictype2<br>\n";
            $sql = "UPDATE poster_signup SET pictype1=$pictype1, pictype2=$pictype2 WHERE id=$row->id ";
            $this->db->query($sql);
        }
    }
}
