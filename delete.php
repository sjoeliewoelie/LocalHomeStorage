<?php
$root = 'C:\Users\admin\Downloads\disk';
if(isset($_POST['delete'])){
	$link = str_replace('/', '\\', $_POST['delete']);
	chmod($root.$link, 0750);
	try{
		if(is_dir($root.$link)){
	    	function deleteDirectory($dir) { 
		    	if (!file_exists($dir)) return true; 
		    	if (!is_dir($dir) || is_link($dir)) return unlink($dir); 
	        	foreach (scandir($dir) as $item) { 
	            	if ($item == '.' || $item == '..') continue; 
	            	if (!deleteDirectory($dir . "/" . $item)) { 
	            	    chmod($dir . "/" . $item, 0777); 
	                	if (!deleteDirectory($dir . "/" . $item)) return false; 
	            	}; 
	        	} 
	        		return rmdir($dir); 
	    	} 
				deleteDirectory($root.$link);
	        }else{
	            unlink($root.$link);
	        }
	                
        }catch(Exception $e){
                
        }
	echo json_encode(['status'=>'OK']);
}
?>