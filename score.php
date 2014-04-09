<?php
	$db = new mysqli('10.202.68.49','film2014','rEKshFDba68cjnSm', 'film2014');

	$ip = $_SERVER['remote_addr'];
	
	$query = 'select * from ip where ip = '.$ip;
	$result = $db->query($query);
	if($result && $result->num_rows == 5){
		echo_jsonp('{"message":"toomany"}');
		exit;
	}
	
	$id = $_POST['id'];
	$cx = $_POST['cx'];
	$bz = $_POST['bz'];
	$js = $_POST['js'];
	$ys = $_POST['ys'];
	$cw = $_POST['cw'];
	
	$query = 'select * from score where id='.$id;
	$result = $db->query($query);
	if($result){
		$num = $result->fetch_array()['num'];
	}else{
		echo_jsonp('{"message":"notfound"}');
		exit;
	}
	
	$query = 'update score set
		cx = cx*'.$num.'+'.$cx.'
		bz = bz*'.$num.'+'.$bz.'
		js = js*'.$num.'+'.$js.'
		ys = ys*'.$num.'+'.$ys.'
		cw = cw*'.$num.'+'.$cw.'
		num = num + 1 where id = '.$id;
	$result = $db->query($query);
	
	
function echo_jsonp($str){
    $callback=isset($_GET["callback"])?$_GET["callback"]:FALSE;
    echo $callback;
    echo '('.$str.')';
}

?>
	