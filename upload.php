<?php
	$db = new mysqli('10.202.68.49','film2014','rEKshFDba68cjnSm', 'film2014');
	$db->set_charset("utf8");
	
	$query = 'select * from author';
	$id = $db->query($query)->num_rows + 1;
	//if($_FILES['img1']['type'] != 'image/jpeg') exit;
	//if($_FILES['img2']['type'] != 'image/jpeg') exit;
	
	/*$upfile = '/img_upload/'.$id.'.jpg';
	if(is_uploaded_files($_FILES['img1']['tmp_name']))
		move_uploaded_file($_FILES['img1']['tmp_name'], $upfile);
	$upfile = '/img_upload/'.$id.'-cos.jpg';
	if(is_uploaded_files($_FILES['img2']['tmp_name']))
		move_uploaded_file($_FILES['img2']['tmp_name'], $upfile);
	*/
	$img1_s	= $_GET['img1'];
	echo $img1_s;
	$img1 = imagecreatefromstring(file_get_contents($img1_s));
	imagejpeg($img1,"./img_upload/".$id.".jpg");
	$img2_s	= $_GET['img2'];
	$img2 = imagecreatefromstring(file_get_contents($img2_s));
	imagejpeg($img2,"./img_upload/".$id."-cos.jpg");
	
	$email		= getdata('email');
	$name		= getdata('name');
	$stuid1 	= getdata('stuid1');
	$stuid2 	= getdata('stuid2');
	$stuid3 	= getdata('stuid3');
	$stuid4 	= getdata('stuid3');
	$stuid5 	= getdata('stuid3');
	$stuid6 	= getdata('stuid3');
	$stuid7 	= getdata('stuid3');
	$name1 		= getdata('name1');
	$name2 		= getdata('name2');
	$name3		= getdata('name3');
	$name4		= getdata('name3');
	$name5		= getdata('name3');
	$name6		= getdata('name3');
	$name7		= getdata('name3');
	$contatc1	= getdata('contact1');
	$contatc2	= getdata('contact2');
	$contatc3	= getdata('contact3');
	$contatc4	= getdata('contact3');
	$contatc5	= getdata('contact3');
	$contatc6	= getdata('contact3');
	$contatc7	= getdata('contact3');

	$query = "insert into author values
		('".$id."', '".$stuid1."', '".$name1."', '".$contact1."', '"
					  .$stuid2."', '".$name2."', '".$contact2."', '"
					  .$stuid3."', '".$name3."', '".$contact3."', '"
					  .$stuid4."', '".$name4."', '".$contact4."', '"
					  .$stuid5."', '".$name5."', '".$contact5."', '"
					  .$stuid6."', '".$name6."', '".$contact6."', '"
					  .$stuid7."', '".$name7."', '".$contact7."')";
	$result = $db->query($query);
	
	$query = "insert into score values
		('".$id."', '0', '0', '0', '0', '0', '0')";
	$result = $db->query($query);
	
	$query = "insert into img values
		('".$id."', '".$name."', '".$email."')";
	$result = $db->query($query);

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