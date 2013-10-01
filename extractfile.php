<?php
$root = 'C:\Users\admin\Downloads\disk';
if(isset($_POST['zipfolder'])){
	$link = str_replace('/', '\\', $_POST['zipfolder']);
	$name = explode('.',$_POST['filename']);
	$ExtLen = strlen($name[count($name)-1]);
	$folderlink = str_replace($_POST['filename'], substr($_POST['filename'],0,strlen($_POST['filename'])-$ExtLen-1), $link);
	if($name[count($name)-1] == 'zip'){
		$zip = new ZipArchive;
		if ($zip->open($root.$link) === true){
			$zip->extractTo($root.$folderlink);
			$zip->close();
			header("Location: http://".$_SERVER['HTTP_HOST'].'?f='.urlencode($folderlink));
		}else{
			echo 'no file. you will be redirect';
			header("Location: http://".$_SERVER['HTTP_HOST']);
		}
	}else if($name[count($name)-1] == 'rar'){
		$cmd = 'cd C:\program files (x86)\7-Zip\ && 7z x "'.$root.$link.'" -o"'.$root.$folderlink.'" -y  ';
		$answer = shell_exec($cmd);
		header("Location: http://".$_SERVER['HTTP_HOST'].'?f='.urlencode($folderlink));
	}else{
		header("Location: http://".$_SERVER['HTTP_HOST']);
	}
}else{
	header("Location: http://".$_SERVER['HTTP_HOST']);
}
?>