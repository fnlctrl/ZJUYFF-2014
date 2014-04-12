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
		$query = 'select * from author';
		echo $db->query($query)->num_rows;
		exit;
	}
	
	$query = 'select * from author where id='.$id;
	$result = $db->query($query);
	$arr = $result->fetch_array();
	
	$query = 'select * from score where id='.$id;
	$result = $db->query($query);
	$arr = array_merge($arr, $result->fetch_array());
	
	$num = $arr['num'];
	if($num){
		$arr['s1'] = (int)($arr['s1']/$num);
		$arr['s2'] = (int)($arr['s2']/$num);
		$arr['s3'] = (int)($arr['s3']/$num);
		$arr['s4'] = (int)($arr['s4']/$num);
		$arr['s5'] = (int)($arr['s5']/$num);
	}
		
	
	echo_jsonp(json_encode($arr));


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