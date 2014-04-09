<?php
	header("Content-type:application/json");
	//header("Content-type:image/jpeg");
	
	$db = new mysqli('10.202.68.49','film2014','rEKshFDba68cjnSm', 'film2014');
	$db->set_charset("utf8");
	
	if(mysqli_connect_errno()){
		echo_jsonp ('{"error": "mysql_connect_error"}');
		die;
	}
	
	$id = $_GET['id'];
	if(!$id){
		$query = 'select * from author';
		echo $db->query($query)->num_rows;
		exit;
	}
//	$im1 = imagecreatefromjpeg('./img/'.$id.'.jpg');
//	$im2 = imagecreatefromjpeg('./img/'.$id.'-cos.jpg');
	
//	$imgarr = array(
//		'img1' => imagejpeg($im1),
//		'img2' => imagejpeg($im2)
//	);
	
	
	$query = 'select * from author where id='.$id;
	$result = $db->query($query);
//	$arr = array_merge($imgarr, $result->fetch_array());
	$arr = $result->fetch_array();
	
	$query = 'select * from score where id='.$id;
	$result = $db->query($query);
	$arr = array_merge($arr, $result->fetch_array());
	
	echo_jsonp(json_encode($arr));


function echo_jsonp($str){
    $callback=isset($_GET["callback"])?$_GET["callback"]:FALSE;
    echo $callback;
    echo '('.$str.')';
}

?>