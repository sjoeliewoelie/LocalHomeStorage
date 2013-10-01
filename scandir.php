<?php
  class Files {
    public $files;
    public $path;
    private $root = 'C:\Users\admin\Downloads\disk\\';
    public function getCurPath(){
      if(isset($_GET['f'])){
        return urldecode($_GET['f']);
      }
      return '';
    }
    public function makeUrl($localLink){
      $re = str_replace(['\\', ' '], ['/', '±'], $localLink);
      $re = urlencode($re);
      return str_replace([urlencode('/'), urlencode('±')], ['/','%20'], $re);
    }
    function GetFiles($dir){
      $files = scandir($dir);
      return array_slice($files,1);
    }

    public function getPath(){
      if(isset($_GET['f'])){
         return $this->root.urldecode($_GET['f']);
      }
      return 'C:\Users\admin\Downloads\disk';
    } 

    public function Init(){
      $this->path = $this->getPath();
      $this->files =  $this->GetFiles($this->path);
    }
  
public function getIco($type){
  preg_match_all('/^[^\/]*/', $type, $group);
  preg_match_all('/^[^\;]*/', $type, $tgroup);
  switch($group[0][0]){
case 'audio':
  $ico = 'audio.png';
break;
case 'application':
  $ico = 'application.png';
  if($tgroup[0][0] == 'application/x-bittorrent'){
    $group[0][0] = 'torrent';
    $ico = 'torrent.png';
  }else if($tgroup[0][0] == 'application/zip'){
    $group[0][0] = 'zip';
    $ico = 'zip.png';
  }else if($tgroup[0][0] == 'application/x-rar'){
    $group[0][0] = 'x-rar';
    $ico = 'archive.png';
  }else{
    $ico = 'application.png';
  }
break;
case 'text':
  $ico = 'document.png';
break;
case 'image':
  if($tgroup[0][0] == 'image/gif'){
    $group[0][0] = 'image';
    $ico = 'gif.png';
  }else{
    $ico = 'image.png';
  }
break;
case 'video':
  $ico = 'video.png';
break; 
default:
  $ico = 'application.png';
break;
}
$result[] = [
  'ico'=>$ico,
  'group'=>$group[0][0],
  'mime'=>$tgroup[0][0],
]; 
return $result;
}
public function getTypeId($type){
  switch ($type) {
    case 'folder':
        return '1';
    break;
    case 'image':
        return '2';
    break;
    case 'audio':
        return '3';
    break;
    case 'video':
        return '4';
    break;
    case 'text':
        return '5';
    break;
    case 'zip':
        return '7';
    break;
    case 'x-rar':
        return '6';
    break;
  }
  return '9';
}
public function OutFiles(){ 
  $outfiles = array();
  $finfo = new finfo(FILEINFO_MIME);
  foreach($this->files as $file){
    if($file !='..'){ 
      if(is_dir($this->path.DIRECTORY_SEPARATOR.$file)){
        $outfiles[] = [
          'name'=>$file,
          'type'=>'folder',
          'ico'=>'folder.png',
          'folder'=>urlencode($this->getCurPath().'\\'.$file),
          'directlink'=>$this->getCurPath().'/'.$file
        ];
      }else{
        $type = $finfo->file($this->path.DIRECTORY_SEPARATOR.$file);
        $types = $this->getIco($type);
        $outfiles[] = [
          'name'=>$file,
          'ico'=>$types[0]['ico'],
          'type'=>$types[0]['group'],
          'mime'=>$types[0]['mime'],
          'infolder'=>$this->getCurPath(),
          'link'=>$this->makeUrl($this->getCurPath().'/'.$file),
          'directlink'=>$this->getCurPath().'/'.$file
        ];
      }
    }
       }
      uasort($outfiles, function($a,$b){
        return strnatcmp($this->getTypeId($a['type']),$this->getTypeId($b['type']));
      });
      return $outfiles;
    }
  }
?>