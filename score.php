<?php
	$db = new mysqli('10.202.68.49','film2014','rEKshFDba68cjnSm', 'film2014');
	$db->set_charset("utf8");
	
	$ip = $_SERVER['REMOTE_ADDR'];
	
	$query = 'select * from ip where ip = '.$ip;
	$result = $db->query($query);
	if($result && $result->num_rows == 5){
		echo_jsonp('{"message":"toomany"}');
		exit;
	}
	
	$id = getdata('id');
	if(!$id) exit;
	$s1 = getdata('s1');
	$s2 = getdata('s2');
	$s3 = getdata('s3');
	$s4 = getdata('s4');
	$s5 = getdata('s5');
	
	$query = 'select * from score where id='.$id;
	$result = $db->query($query);
	if($result){
		$arr = $result->fetch_array();
		$num = $arr['num'];
	}else{
		echo_jsonp('{"message":"notfound"}');
		exit;
	}
	
	
	$query = 'update score set
		s1 = s1 + '.$s1.',
		s2 = s2 + '.$s2.',
		s3 = s3 + '.$s3.',
		s4 = s4 + '.$s4.',
		s5 = s5 + '.$s5.',
		num = num + 1 where id = '.$id;
	$result = $db->query($query);
	
	
function echo_jsonp($str){
    $callback=isset($_GET["callback"])?$_GET["callback"]:FALSE;
    echo $callback;
    echo '('.$str.')';
}

function getdata($varname){
    $res = isset($_GET[$varname])?$_GET[$varname]:0;
	if(!is_numeric($res)) $res = 0;
	if($res > 5 || $res < 0) res = 0;
    return $res;
}

?>
	