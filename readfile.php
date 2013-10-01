<?php
	if(isset($_POST['readf'])){
		$root = 'C:\Users\admin\Downloads\disk';
		$link = str_replace('/', '\\', $_POST['readf']);
		$file = file_get_contents($root.$link);
		echo json_encode(['file'=>$file,'status'=>'OK']);
	}
?>