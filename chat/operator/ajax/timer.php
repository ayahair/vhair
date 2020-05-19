<?php

/*===============================================*\
|| ############################################# ||
|| # JAKWEB.CH / Version 3.1                   # ||
|| # ----------------------------------------- # ||
|| # Copyright 2018 JAKWEB All Rights Reserved # ||
|| ############################################# ||
\*===============================================*/

if (!file_exists('../../config.php')) die('ajax/[available.php] config.php not exist');
require_once '../../config.php';

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !isset($_SESSION['jak_lcp_idhash'])) die("Nothing to see here");

if (!is_numeric($_POST['id'])) die("There is no such user!");

// Update User
$result = $jakdb->update("user", ["available" => $_POST['ops'], "lastactivity" => time(), "session" => session_id()], ["id" => $_POST['id']]);

if ($result) {
	die(json_encode(array('status' => 1)));
} else {
	die(json_encode(array('status' => 0)));
}

?>