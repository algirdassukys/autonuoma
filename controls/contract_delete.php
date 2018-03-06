<?php

include 'libraries/contracts.class.php';
$contractsObj = new contracts();

if(!empty($id)) {
	if(config::FOR_READING_ONLY != 1) {
		// pašaliname užsakytas paslaugas
		$contractsObj->deleteOrderedServices($id);
	
		// šaliname sutartį
		$contractsObj->deleteContract($id);
	} else {
		$removeErrorParameter = '&edit_warning=1';
	}
	
	// nukreipiame į sutarčių puslapį
	header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>