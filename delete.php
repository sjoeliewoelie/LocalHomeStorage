<?php
$root = 'C:\Users\admin\Downloads\disk';
if(isset($_POST['delete'])){
	$link = str_replace('/', '\\', $_POST['delete']);
	chmod($root.$link, 0750);
	//unlink($root.$link);
	echo json_encode(['status'=>'OK']);
}
?>