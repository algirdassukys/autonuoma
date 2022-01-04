<?php
	
	// pradedame sesiją
	session_start();
	
	// nuskaitome konfigūracijų failą
	include 'config.php';

	// iškviečiame bendrųjų funkcijų klasę
	include 'utils/common.class.php';
	
	// iškviečiame prisijungimo prie duomenų bazės klasę
	include 'utils/mysql.class.php';
	
	// nustatome pasirinktą modulį
	$module = '';
	if(isset($_GET['module'])) {
		$module = mysql::escape($_GET['module']);
	}
	
	// jeigu pasirinktas elementas (sutartis, automobilis ir kt.), nustatome elemento id
	$id = '';
	if(isset($_GET['id'])) {
		$id = mysql::escape($_GET['id']);
	}
	
	// nustatome, kokia funkcija kviečiama
	$action = '';
	if(isset($_GET['action'])) {
		$action = mysql::escape($_GET['action']);
	}
		
	// nustatome elementų sąrašo puslapio numerį
	$pageId = 1;
	if(!empty($_GET['page'])) {
		$pageId = mysql::escape($_GET['page']);
	}
	
	// nustatome, kurį valdiklį įtraukti šablone main.tpl.php
    $actionFile = "";
	if(!empty($module) && !empty($action)) {
		$actionFile = "controls/{$module}_{$action}.php";
	} else {
		// rodome, jeigu nenurodyti parametrai
		$actionFile = "controls/home_page.php";
	}
	
	// įtraukiame pagrindinį šabloną
	include 'templates/main.tpl.php';
	
	// spausdiname vykdytas užklausas į konsolę
	common::logToConsole($_SESSION['queries']);
	
	// išvalome vykdytų užklausų masyvą
	$_SESSION['queries'] = array();
?>