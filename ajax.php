<?php
/**
 * @package MusicTheoryByCode
 * @author Daniel Gray <DanielFGray@gmail.com>
 * @copyright 2010
 */

if(!class_exists('Modes'))
	require 'modes.phps';
$r = null;
if(isset($_REQUEST['scale']))
	$r = MusicTheory::newScale($_REQUEST['scale'])->asArray();
else if(isset($_REQUEST['key']))
	$r = MusicTheory::getAllModes($_REQUEST['key'], isset($_REQUEST['relatives']));
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	header('content-type: application/json');
	echo json_encode($r);
} else 
	var_dump($r);