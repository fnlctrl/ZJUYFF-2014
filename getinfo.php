<?php
	header("Content-type:application/json");
	
	$db = new mysqli('10.202.68.49','film2014','rEKshFDba68cjnSm', 'film2014');
	$db->set_charset("utf8");
	
	if(mysqli_connect_errno()){
		echo_jsonp ('{"error": "mysql_connect_error"}');
		die;
	}
	
	$id = getdata('id');
	if(!$id){
		$query = 'select id from author';
		$ret = $db->query($query);
		$rows = array();
		while ($row = $ret->fetch_object()) {
			array_push($rows, intval($row->id));
		}
		echo json_encode($rows);
		exit;
	}
	// 森森注：这儿可能有注入。尽管作了escape，但区间未封闭。请修改
	// 另外，按同和要求，提供了一次返回一张或两张（可选）信息的功能
	// 最后，建议提交GitLab～～～～～噗～
	if (!isset($_GET['id2'])) {
		$_GET['id2'] = -1;
	}
	$query = 'select * from author where id='.$id . ' or id=' . intval($_GET['id2']);
	$result = $db->query($query);
	$arr = $result->fetch_array();
        if ($row = $result->fetch_array()) {
                $arr2 = $row;
        }
	$query = 'select * from score where id='.$id . ' or id=' . intval($_GET['id2']);
	$result = $db->query($query);
	$arr = array_merge($arr, $result->fetch_array());
	if ($row = $result->fetch_array()) {
		$arr2 = array_merge($arr, $row);
	}
	$num = $arr['num'];
	if($num){
		$arr['s1'] = (int)($arr['s1']/$num);
		$arr['s2'] = (int)($arr['s2']/$num);
		$arr['s3'] = (int)($arr['s3']/$num);
		$arr['s4'] = (int)($arr['s4']/$num);
		$arr['s5'] = (int)($arr['s5']/$num);
	}
	if (isset($arr)) {
		$num = $arr['num'];
        	if($num){
                	$arr['s1'] = (int)($arr['s1']/$num);
                	$arr['s2'] = (int)($arr['s2']/$num);
	                $arr['s3'] = (int)($arr['s3']/$num);
	                $arr['s4'] = (int)($arr['s4']/$num);
	                $arr['s5'] = (int)($arr['s5']/$num);
        	}
	}
	$arrs = array();
	if (isset($arr)) {
		array_push($arrs, $arr);
	}
	if (isset($arr2)) {
		array_push($arrs, $arr2);
	}
	echo_jsonp(json_encode($arrs));


function echo_jsonp($str){
    $callback=isset($_GET["callback"])?$_GET["callback"]:FALSE;
    echo $callback;
    echo '('.$str.')';
}

function getdata($varname){
    $res = isset($_GET[$varname])?$_GET[$varname]:FALSE;
	$res = remove_xss($res);
    return $res;
}	
	
function remove_xss($str){
    global $db;
    $str=$db->real_escape_string($str);
    $str=htmlspecialchars($str, ENT_QUOTES);
    return $str;
}

?>
