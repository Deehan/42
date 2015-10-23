<?php
/* Correct Apache charset */
header('Content-Type: text/html; charset=utf-8');

include(dirname(__FILE__).'/settings.php');							
include_once(_FUNC_DIR_.'functions.php');

spl_autoload_register('__autoload');