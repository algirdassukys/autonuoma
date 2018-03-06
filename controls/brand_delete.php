<?php

include 'libraries/brands.class.php';
$brandsObj = new brands();

if(!empty($id)) {
	if(config::FOR_READING_ONLY != 1) {
		// patikriname, ar šalinama markė nepriskirta modeliui
		$count = $brandsObj->getModelCountOfBrand($id);
	
		$removeErrorParameter = '';
		if($count == 0) {
			// šaliname markę
			$brandsObj->deleteBrand($id);
		} else {
			// nepašalinome, nes markė priskirta modeliui, rodome klaidos pranešimą
			$removeErrorParameter = '&remove_error=1';
		}
	} else {
		$removeErrorParameter = '&edit_warning=1';
	}
	
	// nukreipiame į markių puslapį
	header("Location: index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>