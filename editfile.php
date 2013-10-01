<?php
	if(isset($_POST['newtext'])){
		$root = 'C:\Users\admin\Downloads\disk';
		$link = str_replace('/', '\\', $_POST['filefolder']);
		$newtext = $_POST['newtext'];
		chmod($root.$link, 0750);
		$fp = fopen($root.$link, "w");
		fwrite($fp, $newtext);
		fclose($fp);
	}
	header("Location:".$_SERVER['HTTP_REFERER']);
?>