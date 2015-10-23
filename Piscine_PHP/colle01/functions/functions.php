<?php
function __autoload($className) {

	$filename 	= $className.'.class.php';
	$dir		= array(_ENT_DIR_, _CTRL_DIR_);
	
	if(file_exists($dir[0].$filename))
		include_once($dir[0].$filename);
	if(file_exists($dir[1].$filename))
		include_once($dir[1].$filename);
}