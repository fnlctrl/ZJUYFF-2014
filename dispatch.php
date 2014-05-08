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
                setcookie('qsctoken', $args['token'], time() + 3600 * 24 * 30, '/', 'senorsen.com');
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
        } else if (isset($_SERVER['HTTP_REFERER'])) {
            $redir = $_SERVER['HTTP_REFERER'];
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
        if (isset($args['delete'])) {
            $id = intval($args['id']);
            $type = $args['deltype'];
            if (!in_array($type, $wl_view)) {
                return array('code' => 1, 'msg' => 'Type not found');
            }
            $type_dbs = array('dub' => 'dub_team', 'poster' => 'poster_signup');
            $type_db = $type_dbs[$type];
            $sql = "UPDATE $type_db SET valid=0 WHERE id=$id ";
            $this->db->query($sql);
            return array('code' => 0, 'msg' => 'Set valid okay');
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
        $sql = "SELECT * FROM dub_team WHERE valid=1 ";
        $result = $this->db->query($sql);
        $rows = array();
        while ($row = $result->fetch_object()) {
            $dub_rows = array();
            $dub_sql = "SELECT * FROM dub_teammate WHERE tid=$row->id ORDER BY id ";
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
        $sql = "SELECT * FROM poster_signup WHERE valid=1 ";
        $result = $this->db->query($sql);
        $rows = array();
        while ($row = $result->fetch_object()) {
            $m_rows = array();
            $m_sql = "SELECT * FROM poster_member WHERE sid=" . $row->id . " ORDER BY id ";
            $m_result = $this->db->query($m_sql);
            while ($m_row = $m_result->fetch_object()) {
                array_push($m_rows, $m_row);
            }
            $scores = '';
            $score_sql = "SELECT * FROM poster_vote WHERE pid=$row->id ";
            $score_result = $this->db->query($score_sql);
            while ($score_row = $score_result->fetch_object()) {
                $scores .= $score_row->name . ':' . (sprintf("%.2f", $score_row->score / ($score_row->votes == 0 ? 1 : $score_row->votes))) . '(' . $score_row->score . ',' . $score_row->votes . ') ';
            }
            $row->scores = $scores;
            $row->teammate = $m_rows;
            array_push($rows, $row);
        }
        return $rows;
    }
    public function poster($args) {
        $sql = "SELECT id,valid,name,introduction,members,time,suffix1,suffix2,pictype1,pictype2 FROM poster_signup WHERE valid=1 ";
        $result = $this->db->query($sql);
        $s_rows = array();
        $id2vid = array();
        while ($s_row = $result->fetch_object()) {
            $s_row->m = array();
            $sql = "SELECT id,sid,name,leader FROM poster_member WHERE sid=$s_row->id ORDER BY id ";
            $m_res = $this->db->query($sql);
            while ($m_row = $m_res->fetch_object()) {
                array_push($s_row->m, $m_row);
            }
            $sql = "SELECT * FROM poster_vote WHERE pid=$s_row->id ORDER BY id ";
            $vote_result = $this->db->query($sql);
            $vote_rows = array();
            while ($vote_row = $vote_result->fetch_object()) {
                $vote_row->average_score = sprintf("%.2f", intval($vote_row->score) / (intval($vote_row->votes) == 0 ? 1 : intval($vote_row->votes)));
                array_push($vote_rows, $vote_row);
            }
            $s_row->vote_result = $vote_rows;
            if ($user_obj = checkQSCToken()) {
                $sql = "SELECT * FROM poster_vote_log WHERE pid=$s_row->id AND uid=$user_obj->uid ";
                $vote_log_res = $this->db->query($sql);
                if ($vote_log_res->num_rows > 0) {
                    $s_row->is_voted = 1;
                } else {
                    $s_row->is_voted = 0;
                }
            }
            array_push($s_rows, $s_row);
        }
        $page_cfg = array(
            'poster' => $s_rows,
        );
        return $page_cfg;
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
        $sql = "INSERT INTO dub_team (valid, team_name, slogan, method, members, time, ip) VALUES (1, '$team_name', '$slogan', '$method', '$members', NOW(), '$r_ip') ";
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
        if (!isset($introduction)) {
            $introduction = '';
        }
        $ip = $this->db->escape_string(getip());
        if (function_exists('exif_imagetype')) {
            $pictype1 = intval(exif_imagetype($_FILES['img1']['tmp_name']));
            $pictype2 = intval(exif_imagetype($_FILES['img2']['tmp_name']));
            $suffix1 = $this->getsuffix($pictype1);
            $suffix2 = $this->getsuffix($pictype2);
        } else {
            // 未知
            $pictype1 = 0;
            $pictype2 = 0;
        }
        $hash = md5(implode('|', array($name, $introduction, $members[0]['name'])));
        $sql = "SELECT * FROM poster_signup WHERE hash='$hash' ";
        $result = $this->db->query($sql);
        if ($result->num_rows == 0) {
            $sql = "INSERT INTO poster_signup (valid, name, members, pictype1, pictype2, suffix1, suffix2, introduction, time, ip, hash) VALUES (1, '$name', $cnt_members, $pictype1, $pictype2, '$suffix1', '$suffix2', '$introduction', NOW(), '$ip', '$hash') ";
            $this->db->query($sql);
            if ($this->db->errno) {
                return array('code' => 100, 'msg' => '处理poster_signup时遇到数据库插入错误，非常抱歉！请联系 sen@senorsen.com，谢谢啦～');
            }
            $sid = $this->db->insert_id;
        } else {
            $sid = $result->fetch_object()->id;
            $sql = "UPDATE poster_signup SET valid=1, name='$name', members=$cnt_members, pictype1=$pictype1, pictype2=$pictype2, suffix1='$suffix1', suffix2='$suffix2', introduction='$introduction', time=NOW(), ip='$ip', hash='$hash' WHERE id=$sid ";
            $this->db->query($sql);
            $sql = "DELETE FROM poster_member WHERE sid=$sid ";
            $this->db->query($sql);
        }
        $pic1filename = $this->upload_dir . 'img1_' . $sid . $suffix1;
        $pic2filename = $this->upload_dir . 'img2_' . $sid . $suffix2;
        $pic1jpg = $this->upload_dir . 'img1_' . $sid . '.jpg';
        $pic2jpg = $this->upload_dir . 'img2_' . $sid . '.jpg';
        move_uploaded_file($_FILES['img1']['tmp_name'], $pic1filename);
        move_uploaded_file($_FILES['img2']['tmp_name'], $pic2filename);
        $this->convert2jpg($pic1filename, $pic1jpg, $pictype1);
        $this->convert2jpg($pic2filename, $pic2jpg, $pictype2);
        foreach ($members as $value) {
            $value = (object)$value;
            $sql = "INSERT INTO poster_member (sid, name, leader, stuid, contact) VALUES ($sid, '$value->name', $value->leader, '$value->stuid', '$value->contact') ";
            $this->db->query($sql);
            if ($this->db->errno) {
                return array('code' => 100, 'msg' => '处理poster_member时遇到数据库插入错误，非常抱歉！请联系 sen@senorsen.com，谢谢啦～');
            }
        }
        // hotfix for poster vote
        $this->posterVoteParse($args, null, 0);
        return array('code' => 0, 'sid' => $sid, 'msg' => '作品提交成功，感谢参与～');
    }
    public function getsuffix($typeno) {
        $typenp = intval($typeno);
        $types = array('unknown', 'gif', 'jpg', 'png', 'swf', 'psd', 'bmp', 'tiff', 'tiff', 'jpc', 'jp2', 'jpx', 'jb2', 'swc', 'iff', 'wbmp', 'xbm', 'ico');
        return '.' . $types[$typeno];
    }
    public function convert2jpg($orgfile, $destfile, $type) {
        switch ($type) {
            case 1:
                $gdimg = imagecreatefromgif($orgfile);
                break;
            case 3:
                $gdimg = imagecreatefrompng($orgfile);
                break;
            case 6:
                $gdimg = imagecreatefrombmp($orgfile);
                break;
            default:
                return FALSE;
        }
        imagejpeg($gdimg, $destfile, 100);
    }
    public function postervote($args) {
        if (!get('id')) return array('code' => 1, 'msg' => '未指定poster_id');
        $this->posterVoteParse($args, null, 0);
        $id = intval(get('id'));
        $sql = "SELECT * FROM poster_signup WHERE id=$id ";
        $result = $this->db->query($sql);
        if (!$result || !($row = $result->fetch_object())) {
            return array('code' => 2, 'msg' => 'poster_id有误');
        }
        if (!get('slug')) {
            return array('code' => 3, 'msg' => 'slug找不到');
        }
        if (!($userobj = checkQSCToken())) {
            return array('code' => 4, 'msg' => '请登录求是潮通行证');
        }
        $q_uid = intval($userobj->uid);
        $q_pid = $id;
        $sql = "SELECT * FROM poster_vote_log WHERE pid=$id AND uid=$q_uid ";
        $result = $this->db->query($sql);
        if ($result->num_rows > 0) {
            return array('code' => 5, 'msg' => '你已经投过票了');
        }
        if (!is_array(get('slug')) || count(get('slug')) > 5) {
            return array('code' => 6, 'msg' => 'slug超出范围');
        }
        $allow_slugs = array('vote1', 'vote2', 'vote3', 'vote4', 'vote5');
        $slugs_org = get('slug');
        $slugs = array();
        foreach ($slugs_org as $value) {
            if (!in_array($value, $slugs)) {
                array_push($slugs, $value);
            }
        }
        foreach ($slugs as $value) {
            if (!in_array($value, $allow_slugs)) {
                return array('code' => 7, 'msg' => 'slug错误');
            }
        }
        $scores = get('score');
        if (!is_array($scores) || count($scores) != count($slugs)) {
            return array('code' => 8, 'msg' => 'score错误');
        }
        foreach ($scores as $key => $value) {
            $value = intval($value);
            if ($value < 0 || $value > 5) {
                return array('code' => 9, 'msg' => 'score错误2');
            }
            if (!in_array($key, $slugs)) {
                return array('code' => 10, 'msg' => 'score错误3');
            }
        }
        $q_ip = $this->db->escape_string(getip());
        $q_username = $this->db->escape_string($userobj->username);
        $q_email = $this->db->escape_string($userobj->email);
        $q_stuid = $this->db->escape_string($userobj->stuid);
        $q_act = $this->db->escape_string(json_encode($scores));
        $sql = "INSERT INTO poster_vote_log (pid,uid,username,email,stuid,act,ip) VALUES ($q_pid, $q_uid, '$q_username', '$q_email', '$q_stuid', '$q_act', '$q_ip')";
        $this->db->query($sql);
        $sql = "";
        foreach ($scores as $key => $value) {
            $value = intval($value);
            $q_key = $this->db->escape_string($key);
            $sql = "UPDATE poster_vote SET votes=votes+1,score=score+$value WHERE pid=$q_pid AND slug='$q_key' ";
            $this->db->query($sql);
        }
        $sql = "SELECT * FROM poster_vote WHERE pid=$q_pid ORDER BY id ";
        $result = $this->db->query($sql);
        $vote_result = array();
        while ($row = $result->fetch_object()) {
            array_push($vote_result, array(
                'slug' => $row->slug,
                'pid' => $row->pid,
                'id' => $row->id,
                'name' => $row->name,
                'votes' => $row->votes,
                'score' => $row->score,
                'average_score' => sprintf("%.2f", $row->score / ($row->votes == 0 ? 1 : $row->votes)),
            ));
        }
        return array('code' => 0, 'msg' => '投票成功啦，感谢支持！', 'vote_result' => $vote_result);
    }
    public function posterVoteParse($args = null, $arg_id = null, $disp = 0) {
        $ids = array();
        if (is_null($arg_id)) {
            $sql = "SELECT * FROM poster_signup WHERE id NOT IN (SELECT pid FROM poster_vote) ";
            $result = $this->db->query($sql);
            while ($row = $result->fetch_object()) {
                array_push($ids, $row->id);
            }
        } else {
            $arg_id = intval($arg_id);
            $ids = array($arg_id);
        }
        $names = array(
            array('vote1', '创新维度'),
            array('vote2', '逼真维度'),
            array('vote3', '技术维度'),
            array('vote4', '艺术维度'),
            array('vote5', '出位维度'),
        );
        if (is_null($arg_id)) header("Content-Type: text/plain; charset=utf-8");
        foreach ($ids as $id) {
            if (is_null($arg_id) && $disp) {
                echo "Parse for $id: ";
            }
            foreach ($names as $namearr) {
                if (is_null($arg_id) && $disp) {
                    echo $namearr[0] . ' ' . $namearr[1] . ' ';
                }
                $slug = $this->db->escape_string($namearr[0]);
                $name = $this->db->escape_string($namearr[1]);
                $sql = "INSERT INTO poster_vote (pid,slug,name,votes,score) SELECT $id,'$slug','$name',0,0 FROM dual WHERE NOT EXISTS (SELECT * FROM poster_vote WHERE poster_vote.pid=$id AND slug='$slug')";
                $this->db->query($sql);
                if (is_null($arg_id) && $disp) {
                   echo $this->db->affected_rows . "<br>\n";
                }
            }
        }
    }
    public function posterParse() {
        $sql = "SELECT * FROM poster_signup WHERE pictype1=0 or pictype2=0 ";
        $result = $this->db->query($sql);
        while ($row = $result->fetch_object()) {
            echo "ID=$row->id $row->name ";
            $pictype1 = exif_imagetype($this->upload_dir . 'img1_' . $row->id . '.jpg');
            $pictype2 = exif_imagetype($this->upload_dir . 'img2_' . $row->id . '.jpg');
            $suffix1 = $this->getsuffix($pictype1);
            $suffix2 = $this->getsuffix($pictype2);
            $this->convert2jpg($this->upload_dir . 'img1_' . $row->id . '.jpg', $this->upload_dir . 'img1_' . $row->id . '.jpg', $pictype1);
            $this->convert2jpg($this->upload_dir . 'img2_' . $row->id . '.jpg', $this->upload_dir . 'img2_' . $row->id . '.jpg', $pictype2);
            echo "pictype1=$pictype1, pictype2=$pictype2<br>\n";
            $sql = "UPDATE poster_signup SET pictype1=$pictype1, pictype2=$pictype2 WHERE id=$row->id ";
            $this->db->query($sql);
        }
    }
    public function uploadany($args) {
        $id = intval($args['id']);
        $sql = "UPDATE poster_signup SET pictype1=2,pictype2=2,suffix1='.jpg',suffix2='.jpg' WHERE id=$id ";
        $pic1filename = $this->upload_dir . 'img1_' . $id . '.jpg';
        $pic2filename = $this->upload_dir . 'img2_' . $id . '.jpg';
        unlink($pic1filename);
        unlink($pic2filename);
        move_uploaded_file($_FILES['img1']['tmp_name'], $pic1filename);
        move_uploaded_file($_FILES['img2']['tmp_name'], $pic2filename);
        echo "Maybe succeed, check by yourself...\n";
    }
    public function getposter($args) {
        $allows = array('type', 'id', 'width', 'height', 'quality');
        foreach ($args as $key => $value) {
            if (in_array($key, $allows)) {
                $$key = $value;
            }
        }
        foreach ($allows as $value) {
            if (!isset($args[$value])) {
                $$value = 0;
            }
        }
        if ($quality == 0) {
            $quality = 60;
        }
        $width = intval($width);
        $height = intval($height);
        $quality = intval($quality);
        $id = intval($id);
        $type = intval($type);
        if (!in_array($type, array(1, 2))) return FALSE;
        $sql = "SELECT * FROM poster_signup WHERE id=$id ";
        $result = $this->db->query($sql);
        if (!$result) {
            errorPage('空集');
        }
        $row = $result->fetch_array();
        if (in_array($row['pictype' . $type], array(1, 2, 3, 6))) {
            $suffix = '.jpg';
        } else {
            $suffix = $row['suffix' . $type];
        }
        $mimetype = image_type_to_mime_type($row['pictype' . $type]);
        $filename = $this->upload_dir . 'img' . $type . '_' . $id . $suffix;
        if (!file_exists($filename)) {
            errorPage('文件不存在');
        }
        header("Content-Type: image/jpeg");
        $org = imagecreatefromjpeg($filename);
        $processed = intval($this->db->query("SELECT processed FROM poster_signup WHERE id=$id ")->fetch_object()->processed);
        if ($width == 0 || imagesx($org) <= $width || imagesy($org) <= $height) {
            if (judgeifmod($filename)) {
                imagejpeg($org, null, 100);
            }
            return TRUE;
        }
        $cache_file = $this->upload_dir . 'img' . $type . '_' . $id . '_' . $width . '_' . $height . '_' . $quality . '.jpg';
        if (!judgeifmod($cache_file)) {
            return TRUE;
        }
        if (file_exists($cache_file) && $processed) {
            echo file_get_contents($cache_file);
            return TRUE;
        }
        $this->db->query("UPDATE poster_signup SET processed=1 WHERE id=$id ");
        new resizeimage($org, $width, $height, 0, $cache_file, $quality);
        judgeifmod($cache_file);
        echo file_get_contents($cache_file);
        return TRUE;
    }
}
