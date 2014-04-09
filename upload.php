<?php
	$db = new mysqli('10.202.68.49','film2014','rEKshFDba68cjnSm', 'film2014');
	$db->set_charset("utf8");
	
	if($_FILES['img1']['type'] != 'image/jpeg') exit;
	if($_FILES['img2']['type'] != 'image/jpeg') exit;
	
	$query = 'select * from author';
	$id = $db->query($query)->num_rows() + 1;
	
	$upfile = '/img_upload/'.$id.'.jpg';
	if(is_uploaded_files($_FILES['img1']['tmp_name']))
		move_uploaded_file($_FILES['img1']['tmp_name'], $upfile);
	$upfile = '/img_upload/'.$id.'-cos.jpg';
	if(is_uploaded_files($_FILES['img2']['tmp_name']))
		move_uploaded_file($_FILES['img2']['tmp_name'], $upfile);
	
	$intro		= $_POST['intro'];
	$name		= $_POST['name'];
	$stuid1 	= $_POST['stuid1'];
	$stuid2 	= $_POST['stuid2'];
	$stuid3 	= $_POST['stuid3'];
	$name1 		= $_POST['name1'];
	$name2 		= $_POST['name2'];
	$name3		= $_POST['name3'];
	$college1	= $_POST['college1'];
	$college2	= $_POST['college2'];
	$college3	= $_POST['college3'];
	$contatc1	= $_POST['contact1'];
	$contatc2	= $_POST['contact2'];
	$contatc3	= $_POST['contact3'];
	$intro		= $_POST['intro'];
	$name		= $_POST['name'];

	$query = "insert into author values
		('".$id."', '".$stuid1."', '".$name1."', '".$college1."', '".$contact1."', '"
					  .$stuid2."', '".$name2."', '".$college2."', '".$contact2."', '"
					  .$stuid3."', '".$name3."', '".$college3."', '".$contact3."')";
	$result = $db->query($query);
	
	$query = "insert into score values
		('".$id."', '0', '0', '0', '0', '0', '0')";
	$result = $db->query($query);
	
	$query = "insert into img values
		('".$id."', '".$name."', '".$intro."')";
	$result = $db->query($query);
?>