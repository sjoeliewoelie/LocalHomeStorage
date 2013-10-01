<?php
$root = 'C:\Users\admin\Downloads\disk';
if($_POST['folder'] != 'null'){
	$root.=$_POST['folder'];
	$folderlink = $_POST['folder'] ;
}else{
	$folderlink = '';
}

function getNewName($filename){
	global $root;
	if(!is_dir($root.DIRECTORY_SEPARATOR.basename($filename))){
		return $filename;
	}
	preg_match_all('/\(([0-9]+)\)$/', $filename, $part);
	if(count($part[1])>0){
		return getNewName(str_replace($part[0][0], '('.($part[1][0] + 1).')', $filename));
	}
	return getNewName($filename.'(1)');
}
$newname = getNewName($_POST['foldername']);
mkdir($root.DIRECTORY_SEPARATOR.basename($newname));
header("Location: http://".$_SERVER['HTTP_HOST'].'?f='.urlencode($folderlink.DIRECTORY_SEPARATOR.$newname));

?>