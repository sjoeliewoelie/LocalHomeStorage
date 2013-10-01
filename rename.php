<?php
$root = 'C:\Users\admin\Downloads\disk';
if(isset($_POST['newname'])){
	$link = str_replace('/', '\\', $_POST['oldname']);
	$link2 = str_replace('/', '\\', $_POST['newname']);
	$link3 = str_replace('/', '\\', $_POST['folder']);
	if($_POST['folder'] == ''){
		rename($root.DIRECTORY_SEPARATOR.$link,$root.DIRECTORY_SEPARATOR.$link2);
	}else{
		rename($root.$link3.DIRECTORY_SEPARATOR.$link,$root.$link3.DIRECTORY_SEPARATOR.$link2);
	}
}
header("Location:".$_SERVER['HTTP_REFERER']);
?>