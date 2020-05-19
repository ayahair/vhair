<?php
// Version
define('VERSION', '2.3.0.2');
// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}
// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}
require_once(DIR_SYSTEM . 'startup.php');
start('catalog');



// VirtualQMOD
require_once('./vqmod/vqmod.php');
$vqmod = new VQMod();

// VQMODDED Startup
require_once($vqmod->modCheck(DIR_SYSTEM . 'startup.php'));
start('catalog');