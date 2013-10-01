<?php
$root = 'C:\Users\admin\Downloads\disk';
$n = 0;
if(isset($_POST['folder'])){
	$root.=urldecode($_POST['folder']);
}

function getNewName($filename){
	global $root;
	if(!file_exists($root.DIRECTORY_SEPARATOR.basename($filename))){
		return $filename;
	}
	preg_match_all('/\.[^\.]+$/', $filename, $extension);
	preg_match_all('/\(([0-9]+)\)\.[^\.]+$/', $filename, $part);
	if(count($part[1])>0){
		return getNewName(str_replace($part[0][0], '('.($part[1][0] + 1).')'.$extension[0][0], $filename));
	}
	return getNewName(str_replace($extension[0][0], '(1)'.$extension[0][0], $filename));
}
$newname = getNewName($_FILES['file']['name']);
move_uploaded_file($_FILES['file']['tmp_name'],$root.DIRECTORY_SEPARATOR.basename($newname));

echo json_encode(['name'=>$newname,'MIME'=>mime_content_type($root.DIRECTORY_SEPARATOR.basename($newname))]);
?>