<?php
$currentDir = dirname(__FILE__);

class site {
	const _BASEURL		= 'http://war.local.42.fr:8080/';
}

define('_ROOT_DIR_',        realpath($currentDir.'/..'));

define('_DOC_DIR_',			_ROOT_DIR_.'/doc/');
define('_CONFIG_DIR_',		_ROOT_DIR_.'/conf/');
define('_CLASSES_DIR_',    	_ROOT_DIR_.'/classes/');
define('_FUNC_DIR_',    	_ROOT_DIR_.'/functions/');
define('_ENT_DIR_',    		_ROOT_DIR_.'/entities/');
define('_CTRL_DIR_',    	_ROOT_DIR_.'/controllers/');
define('_VIEW_DIR_',   		_ROOT_DIR_.'/view/');

define('_H_VIEW_DIR_',		site::_BASEURL.'view/');
define('_H_JS_DIR_',   		_H_VIEW_DIR_.'js/');
define('_H_CSS_DIR_',   	_H_VIEW_DIR_.'css/');