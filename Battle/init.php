<?php
# page php header, init tout ce qui doit l'etre
ini_set('display_errors', 1);
require ('./conf/config.php');
require(_CLASSES_DIR_.'Application.class.php');
include_once(_CLASSES_DIR_.'Component.class.php');
include_once(_ENT_DIR_.'Basic_ent.class.php');
include_once(_ENT_DIR_.'Game.class.php');
include_once(_ENT_DIR_.'Player.class.php');
session_start();
ini_set('error_reporting', E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR);