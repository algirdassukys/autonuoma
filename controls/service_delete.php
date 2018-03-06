<?php

include 'libraries/services.class.php';
$servicesObj = new services();

if(!empty($id)) {
	if(!defined('FOR_READING_ONLY')) {
		// patikriname, ar šalinama paslauga nenaudojama jokioje sutartyje
		$contractCount = $servicesObj->getContractCountOfService($id);
	
		$removeErrorParameter = '';
		if($contractCount == 0) {
			// pašaliname paslaugos kainas
			$servicesObj->deleteServicePrices($id);
	
			// pašaliname paslaugą
			$servicesObj->deleteService($id);
		} else {
			// nepašalinome, nes modelis priskirtas bent vienam automobiliui, rodome klaidos pranešimą
			$removeErrorParameter = '&remove_error=1';
		}
	} else {
		$removeErrorParameter = '&edit_warning=1';
	}

	// nukreipiame į paslaugų puslapį
	header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}
	
?>