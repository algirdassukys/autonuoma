<?php

include 'libraries/models.class.php';
$modelsObj = new models();

if(!empty($id)) {
	if(config::FOR_READING_ONLY != 1) {
		// patikriname, ar šalinamas modelis nenaudojamas, t.y. nepriskirtas jokiam automobiliui
		$count = $modelsObj->getCarCountOfModel($id);
	
		$removeErrorParameter = '';
		if($count == 0) {
			// pašaliname modelį
			$modelsObj->deleteModel($id);
		} else {
			// nepašalinome, nes modelis priskirtas bent vienam automobiliui, rodome klaidos pranešimą
			$removeErrorParameter = '&remove_error=1';
		}
	} else {
		$removeErrorParameter = '&edit_warning=1';
	}

	// nukreipiame į modelių puslapį
	header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>